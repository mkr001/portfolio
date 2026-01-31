<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobPortalTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_register_a_job_seeker()
    {
        $response = $this->post(route('portal.register.post'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'job_seeker',
        ]);

        $response->assertRedirect(route('portal.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'job_seeker',
        ]);
    }

    /** @test */
    public function it_can_register_an_employer()
    {
        $response = $this->post(route('portal.register.post'), [
            'name' => 'Jane Boss',
            'email' => 'jane@company.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'employer',
        ]);

        $response->assertRedirect(route('portal.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'jane@company.com',
            'role' => 'employer',
        ]);
    }

    /** @test */
    public function job_seeker_can_upload_cv()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'job_seeker']);
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('resume.pdf', 100);

        $response = $this->post(route('portal.upload_cv'), [
            'job_title' => 'Laravel Developer',
            'cv' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->id,
            'job_title' => 'Laravel Developer',
            'status' => 'pending',
        ]);

        // Check if file stored
        $application = JobApplication::where('user_id', $user->id)->first();
        Storage::disk('public')->assertExists($application->cv_path);
    }

    /** @test */
    public function employer_can_view_dashboard_and_applicants()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        
        $this->actingAs($employer)
             ->get(route('portal.dashboard'))
             ->assertOk()
             ->assertViewIs('portal.employer_dashboard');

        $this->actingAs($employer)
             ->get(route('portal.applicants'))
             ->assertOk()
             ->assertViewIs('portal.applicants');
    }

    /** @test */
    public function job_seeker_cannot_view_applicants()
    {
        $seeker = User::factory()->create(['role' => 'job_seeker']);
        
        $this->actingAs($seeker)
             ->get(route('portal.applicants'))
             ->assertRedirect(route('portal.dashboard'));
    }

    /** @test */
    public function employer_can_update_status()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        
        // Create a seeker and application
        $seeker = User::factory()->create(['role' => 'job_seeker']);
        $application = JobApplication::create([
            'user_id' => $seeker->id,
            'job_title' => 'Dev',
            'cv_path' => 'dummy.pdf',
            'status' => 'pending',
        ]);

        $this->actingAs($employer)
             ->post(route('portal.update_status', $application), [
                 'status' => 'shortlisted',
             ])
             ->assertSessionHas('success');

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'shortlisted',
        ]);
    }

    /** @test */
    public function employer_viewing_cv_increments_count()
    {
        Storage::fake('public');
        
        // Create dummy file
        $file = UploadedFile::fake()->create('resume.pdf', 100);
        $path = $file->store('cvs', 'public');

        $employer = User::factory()->create(['role' => 'employer']);
        $seeker = User::factory()->create(['role' => 'job_seeker']);
        
        $application = JobApplication::create([
            'user_id' => $seeker->id,
            'job_title' => 'Dev',
            'cv_path' => $path,
            'views' => 0,
        ]);

        $this->actingAs($employer)
             ->get(route('portal.view_cv', $application))
             ->assertOk(); // Should stream download

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'views' => 1,
        ]);
    }
    /** @test */
    public function admin_can_view_job_portal_management()
    {
        $this->withSession(['admin_logged_in' => true])
             ->get(route('admin.career_requests'))
             ->assertOk()
             ->assertViewIs('admin.career_requests');
    }

    /** @test */
    public function admin_can_update_application_status()
    {
        $seeker = User::factory()->create(['role' => 'job_seeker']);
        $application = JobApplication::create([
            'user_id' => $seeker->id,
            'job_title' => 'Dev',
            'cv_path' => 'dummy.pdf',
            'status' => 'pending',
        ]);

        $this->withSession(['admin_logged_in' => true])
             ->post(route('admin.career_requests.status', $application), [
                 'status' => 'rejected',
             ])
             ->assertRedirect()
             ->assertSessionHas('success');

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'rejected',
        ]);
    }

    /** @test */
    public function admin_can_download_cv()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('resume.pdf', 100);
        $path = $file->store('cvs', 'public');

        $seeker = User::factory()->create(['role' => 'job_seeker']);
        $application = JobApplication::create([
            'user_id' => $seeker->id,
            'job_title' => 'Dev',
            'cv_path' => $path,
            'status' => 'pending',
        ]);

        $this->withSession(['admin_logged_in' => true])
             ->get(route('admin.career_requests.download', $application))
             ->assertOk(); 
    }
}
