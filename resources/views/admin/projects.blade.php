@extends('admin.layout')

@section('content')
<div class="mb-10 flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-bold text-purple-500">Manage Projects</h1>
        <p class="text-gray-400 mt-2">Add, edit, or remove projects from your portfolio.</p>
    </div>
    <button onclick="openAddModal()" class="px-8 py-3 bg-purple-600 rounded-full font-bold shadow-lg shadow-purple-500/20 hover:bg-purple-700 transition">
        + Add New Project
    </button>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-2xl font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($projects as $project)
    <div class="card p-6 rounded-3xl relative overflow-hidden group flex flex-col">
        <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition z-10">
            <button onclick="openEditModal({{ json_encode($project) }})" class="p-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition">✏️</button>
            <form action="{{ route('admin.projects.delete', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition">🗑️</button>
            </form>
        </div>
        
        @if($project->image)
            <img src="{{ $project->image }}" class="w-full h-32 object-cover rounded-2xl mb-4 border border-white/10">
        @endif

        <div class="text-xs font-bold text-purple-500 uppercase mb-2 tracking-wider">{{ $project->category ?? 'Web' }}</div>
        <h3 class="text-xl font-bold mb-3 text-white">{{ $project->title }}</h3>
        <p class="text-gray-400 text-sm mb-6 leading-relaxed flex-grow">{{ Str::limit($project->description, 100) }}</p>
        
        @if($project->link)
        <a href="{{ $project->link }}" target="_blank" class="text-xs font-bold text-blue-500 hover:underline truncate">
            🔗 {{ $project->link }}
        </a>
        @endif
    </div>
    @empty
    <div class="col-span-full border-2 border-dashed border-white/5 rounded-3xl p-20 text-center text-gray-500 italic">
        No projects found in the database.
    </div>
    @endforelse
</div>

<!-- Modal Container -->
<div id="modalContainer" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden p-6">
    <div class="card w-full max-w-lg p-10 rounded-3xl shadow-2xl">
        <h2 id="modalTitle" class="text-3xl font-bold mb-6 text-purple-500">New Project</h2>
        <form id="projectForm" action="{{ route('admin.projects.store') }}" method="POST" class="space-y-4">
            @csrf
            <div id="methodField"></div>
            <div>
                <label class="block text-gray-400 mb-1">Title</label>
                <input type="text" name="title" id="form_title" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-400 mb-1">Category</label>
                    <select name="category" id="form_category" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition appearance-none">
                        <option value="web">Web</option>
                        <option value="java">Java</option>
                        <option value="ai">AI</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 mb-1">Project Link</label>
                    <input type="url" name="link" id="form_link" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
            <div>
                <label class="block text-gray-400 mb-1">Image URL</label>
                <input type="text" name="image" id="form_image" placeholder="https://example.com/image.jpg" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition">
            </div>
            <div>
                <label class="block text-gray-400 mb-1">Description</label>
                <textarea name="description" id="form_description" rows="4" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition"></textarea>
            </div>
            <div class="flex gap-4 pt-4">
                <button type="submit" id="submitBtn" class="flex-1 bg-purple-600 text-white font-bold py-3 rounded-xl hover:bg-purple-700 transition">Create Project</button>
                <button type="button" onclick="closeModal()" class="px-6 py-3 bg-white/5 text-gray-400 rounded-xl hover:bg-white/10 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalContainer');
    const form = document.getElementById('projectForm');
    const methodField = document.getElementById('methodField');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');

    function openAddModal() {
        modalTitle.innerText = "New Project";
        submitBtn.innerText = "Create Project";
        form.action = "{{ route('admin.projects.store') }}";
        methodField.innerHTML = '';
        form.reset();
        modal.classList.remove('hidden');
    }

    function openEditModal(project) {
        modalTitle.innerText = "Edit Project";
        submitBtn.innerText = "Update Project";
        form.action = `/admin/projects/${project.id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('form_title').value = project.title;
        document.getElementById('form_category').value = project.category || 'web';
        document.getElementById('form_link').value = project.link || '';
        document.getElementById('form_image').value = project.image || '';
        document.getElementById('form_description').value = project.description;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>



<div class="mt-8">
    {{ $projects->links() }}
</div>
@endsection
