<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mukesh Kumar Ray | Portfolio</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
<style>
  html { scroll-behavior: smooth; }
  body { font-family: 'Outfit', sans-serif; background-color: #020617; color: #f1f5f9; cursor: none; }


  /* Premium Gradient System */
  .section-bg {
    background: radial-gradient(circle at top right, #0f172a, #020617);
    position: relative;
    overflow: hidden;
  }
  
  .section-bg::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
    top: -200px;
    right: -200px;
    z-index: 0;
  }

  .card { 
    background: rgba(15, 23, 42, 0.4); 
    backdrop-filter: blur(12px); 
    border: 1px solid rgba(59, 130, 246, 0.2);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .card:hover {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
    transform: translateY(-5px);
  }


  input, textarea, select {
    background: rgba(15, 23, 42, 0.6) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #f8fafc !important;
    transition: all 0.3s ease;
  }

  input:focus, textarea:focus, select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 15px rgba(59, 130, 246, 0.3) !important;
    background: rgba(15, 23, 42, 0.9) !important;
  }

  label { color: #94a3b8 !important; font-weight: 500; letter-spacing: 0.025em; }


  /* Custom Cursor */
  #cursor {
    width: 20px;
    height: 20px;
    background: #3b82f6;
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9999;
    mix-blend-mode: difference;
    transition: transform 0.1s ease;
  }
  #cursor-follower {
    width: 40px;
    height: 40px;
    border: 2px solid #3b82f6;
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9998;
    transition: transform 0.2s ease, top 0.15s ease, left 0.15s ease;
  }

  .typing-text { border-right: 2px solid #3b82f6; white-space: nowrap; overflow: hidden; display:inline-block; }
  
  nav { 
    background-color: rgba(2, 6, 23, 0.8) !important; 
    backdrop-filter: blur(20px); 
    border-bottom: 1px solid rgba(59, 130, 246, 0.2); 
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
  }
  
  .nav-link { color: #94a3b8; font-weight: 500; }
  .nav-link:hover { color: #3b82f6; text-shadow: 0 0 10px rgba(59, 130, 246, 0.5); }

  .text-blue-500 { color: #3b82f6 !important; }
  .text-blue-600 { color: #2563eb !important; }
  .text-green-500 { color: #10b981 !important; }
  .text-green-600 { color: #059669 !important; }

  /* Section highlights */
  h2 {
    background: linear-gradient(to right, #3b82f6, #60a5fa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
  }
</style>
</head>
<body>
<!-- Premium Preloader -->
<div id="preloader" class="fixed inset-0 z-[100] bg-slate-950 flex flex-col justify-center items-center">
  <div class="relative">
    <div class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 opacity-20 select-none">MUKESH</div>
    <div id="preloader-text" class="absolute inset-0 flex justify-center items-center text-4xl md:text-6xl font-bold text-white uppercase tracking-tighter">
      0%
    </div>
  </div>
  <div class="w-48 h-1 bg-white/10 rounded-full mt-8 overflow-hidden">
    <div id="preloader-bar" class="w-0 h-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.6)]"></div>
  </div>
</div>

<div id="cursor"></div>
<div id="cursor-follower"></div>

<!-- Back to Top -->
<button id="backToTop" class="fixed bottom-10 right-10 z-50 p-4 bg-blue-500 rounded-full shadow-2xl opacity-0 transition-opacity duration-300 pointer-events-none">
  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
</button>


<!-- Navbar -->
<nav class="fixed w-full z-50 shadow-md">
  <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
    <div class="text-2xl font-bold text-blue-500">Mukesh Kumar Ray</div>
    <div class="space-x-6 hidden md:flex">
      <a href="#home" class="nav-link hover:text-blue-500 transition">Home</a>
      <a href="#about" class="nav-link hover:text-blue-500 transition">About</a>
      <a href="#experience" class="nav-link hover:text-blue-500 transition">Experience</a>
      <a href="#skills" class="nav-link hover:text-blue-500 transition">Skills</a>
      <a href="#education" class="nav-link hover:text-blue-500 transition">Education</a>
      <a href="#projects" class="nav-link hover:text-blue-500 transition">Projects</a>
      <a href="#services" class="nav-link hover:text-blue-500 transition">Services</a>
      <a href="#contact" class="nav-link hover:text-blue-500 transition">Contact</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section id="home" class="section-bg h-screen flex flex-col justify-center items-center text-center relative overflow-hidden pt-16 show">
  <img src="{{ asset('images/profile.jpg') }}" alt="Mukesh Kumar Ray" 
       class="w-48 h-48 rounded-full border-4 border-blue-500 shadow-2xl mb-6 hover:scale-105 transition-transform duration-500">
  <h1 class="text-5xl md:text-6xl font-bold mb-2">Hi, I'm <span class="text-blue-500">Mr Mukesh 360&deg</span></h1>
  <p class="text-xl md:text-2xl mb-6 font-semibold">
    <span class="typing-text" id="typing"></span>
  </p>
  <div class="space-x-4">
    <a href="#projects" class="bg-gradient-to-r from-blue-400 to-blue-600 text-white px-6 py-3 rounded shadow hover:from-blue-500 hover:to-blue-700 transition">View Projects</a>
    <a href="{{ asset('Mukesh_Kumar_Ray_Resume.pdf') }}" download class="border border-blue-500 px-6 py-3 rounded hover:bg-blue-500 hover:text-white transition">Download Resume</a>
  </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">About Me</h2>
  
  <div class="max-w-6xl mx-auto px-6 rounded-2xl shadow-2xl space-y-6 text-center md:text-left">
    <p class="text-lg text-slate-400 leading-relaxed">
      I am a <span class="font-semibold text-blue-600">passionate and detail-oriented developer</span> with strong expertise in 
      <span class="font-semibold">Java web development</span> and solid command over both 
      <span class="font-semibold">frontend and backend technologies</span>. 
      I thrive in environments that foster <span class="italic">creativity, innovation, and continuous learning</span>, while contributing meaningfully to organizational growth.
    </p>
    <p class="text-lg text-slate-400 leading-relaxed">
      My skill set includes <span class="font-semibold">Java, PHP, Laravel, React.js, Node.js, and MySQL</span>, along with modern frameworks 
      like <span class="font-semibold">Tailwind CSS</span> and <span class="font-semibold">Bootstrap</span>.  
      I am proficient in <span class="font-semibold">Collection Frameworks, JDBC, and Git</span>, and I have hands-on experience with industry-standard tools 
      such as <span class="font-semibold">Eclipse, VS Code, and JDK</span>.
    </p>
    <p class="text-lg text-slate-400 leading-relaxed">
      With a strong foundation in problem-solving and application development, 
      I aim to build <span class="font-semibold text-blue-600">scalable, efficient, and user-friendly solutions</span> that make a real impact.
    </p>
  </div>
</section>

<!-- Experience Section -->
<section id="experience" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Experience</h2>
  
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      
      <!-- Card 1 -->
      <div class="card p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-transform duration-300 hover:-translate-y-2">
        <div class="flex items-center gap-3 mb-3">
          <img src="/images/quality.png" alt="Quality Austria Logo" class="w-10 h-10 object-contain">
          <h3 class="text-2xl font-semibold text-blue-600">Quality Analyst</h3>
        </div>
        <p class="text-lg text-slate-200 font-medium">
          <a href="https://www.qualityaustriacentralasia.com/" target="_blank" rel="noopener noreferrer">Quality Austria Central Asia Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Oct 2024 – Feb 2025 | Bengaluru, India</p>
        <ul class="list-disc list-inside text-slate-400 space-y-2">
          <li>Developed and optimized <span class="font-semibold">Java-based web applications</span>.</li>
          <li>Collaborated with cross-functional teams to design, test, and deploy new features.</li>
          <li>Participated in peer <span class="font-semibold">code reviews</span> to uphold coding standards.</li>
        </ul>
      </div>
      
      <!-- Card 2 -->
      <div class="card p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-transform duration-300 hover:-translate-y-2">
        <div class="flex items-center gap-3 mb-3">
          <img src="/images/rmsi.png" alt="RMSI Logo" class="w-10 h-10 object-contain">
          <h3 class="text-2xl font-semibold text-blue-600">Data Analyst</h3>
        </div>
        <p class="text-lg text-slate-200 font-medium">
          <a href="https://www.rmsi.com/" target="_blank" rel="noopener noreferrer">RMSI Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Jun 2024 – Aug 2024 | Noida, India</p>
        <ul class="list-disc list-inside text-slate-400 space-y-2">
          <li>Performed <span class="font-semibold">data mapping, annotation, and entry</span> for GIS projects.</li>
          <li>Ensured <span class="font-semibold">data consistency</span> across datasets.</li>
          <li>Collaborated with team members to <span class="font-semibold">streamline workflows</span>.</li>
        </ul>
      </div>
      
      <!-- Card 3 -->
      <div class="card p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-transform duration-300 hover:-translate-y-2 border-l-4 border-blue-600">
        <div class="flex items-center gap-3 mb-3">
          <img src="/images/merums.png" alt="Merums Logo" class="w-10 h-10 object-contain">
          <h3 class="text-2xl font-semibold text-blue-600">PHP Developer</h3>
        </div>
        <p class="text-lg text-slate-200 font-medium">
          <a href="https://merums.com/" target="_blank" rel="noopener noreferrer">Merums Shared Services Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Feb 2025 – Present | Delhi, India</p>
        <ul class="list-disc list-inside text-slate-400 space-y-2">
          <li>Developing and maintaining <span class="font-semibold">PHP-based web applications</span>.</li>
          <li>Integrating APIs and working with <span class="font-semibold">MySQL databases</span>.</li>
          <li>Collaborating with designers and frontend developers for <span class="font-semibold">UI/UX</span>.</li>
          <li>Debugging and optimizing performance.</li>
        </ul>
      </div>
      
    </div>
  </div>
</section>



<!-- Skills Section -->
<section id="skills" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Technical Skills</h2>
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6">
    <!-- Skill Bars -->
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>PHP</span><span>85%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 h-5 rounded-full skill-bar" data-percent="85"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>Laravel</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-green-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>HTML/CSS/JS</span><span>90%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-yellow-400 via-red-400 to-pink-500 h-5 rounded-full skill-bar" data-percent="90"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>React.js</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-teal-400 to-green-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>Bootstrap/Tailwind CSS</span><span>85%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 h-5 rounded-full skill-bar" data-percent="85"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>Node.js</span><span>75%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-green-400 via-lime-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="75"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>MySQL</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-red-400 via-orange-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-slate-400"><span>Java</span><span>90%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 h-5 rounded-full skill-bar" data-percent="90"></div></div>
    </div>
  </div>
</section>

<!-- Education Section -->
<section id="education" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Education</h2>
  
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
    
    <!-- B.Tech Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <h3 class="text-2xl font-bold mb-3 text-blue-600">B.Tech in CSE</h3>
      <p class="text-slate-400 mb-1 font-medium">
        <a href="https://ptu.ac.in//" target="_blank" class="text-blue-600 hover:underline">I.K. Gujral Punjab Technical University, Jalandhar</a>
      </p>
      <p class="text-gray-500">Graduated: 2024 | Location: Punjab, India</p>
    </div>
    
    <!-- 12th Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <h3 class="text-2xl font-bold mb-3 text-green-600">12th - Science</h3>
      <p class="text-slate-400 mb-1 font-medium">
        <a href="http://biharboardonline.bihar.gov.in/" target="_blank" class="text-green-600 hover:underline">Bihar School Examination Board</a>
      </p>
      <p class="text-gray-500">Year: 2020 | Location: Bihar, India</p>
    </div>
    
    <!-- 10th Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <h3 class="text-2xl font-bold mb-3 text-yellow-600">10th</h3>
      <p class="text-slate-400 mb-1 font-medium">
        <a href="http://biharboardonline.bihar.gov.in/" target="_blank" class="text-yellow-600 hover:underline">Bihar School Examination Board</a>
      </p>
      <p class="text-gray-500">Year: 2018 | Location: Bihar, India</p>
    </div>
    
  </div>
</section>

<!-- Training & Certification Section -->
<section id="training" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Training & Certifications</h2>
  
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6">
    
    <!-- Training 1: QSpiders Java Full Stack -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <div class="flex items-center mb-4">
        <img src="/images/qsp.png" alt="QSpiders Logo" class="w-12 h-12 object-contain mr-3">
        <h3 class="text-2xl font-bold text-blue-600">Java Full Stack Training</h3>
      </div>
      <p class="text-slate-400 mb-1 font-medium">
        <a href="https://www.qspiders.com/" target="_blank" class="text-blue-600 hover:underline">QSpiders, Noida</a>
      </p>
      <p class="text-gray-500">2024 | Core Java, HTML, CSS, MySQL, React.js | IDEs: Eclipse, VS Code | Tools: Git, GitHub</p>
    </div>
    
    <!-- Training 2: Apna College Java + DSA -->
<div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

  <div class="flex flex-col items-center mb-4">
    <img src="/images/apana.png" alt="Apna College Logo" class="w-20 h-auto object-contain mb-3">
    <h3 class="text-2xl font-bold text-purple-600 text-center">Java + DSA Training</h3>
  </div>
  <p class="text-slate-400 mb-1 font-medium text-center">
    <a href="https://www.apnacollege.in/course/placement-course-java" target="_blank" class="text-purple-600 hover:underline">Apna College</a>
  </p>
  <p class="text-gray-500 text-center">2024 | Java Programming, Data Structures & Algorithms | 400+ Lectures, 300+ Coding Questions | Instructor: Shradha Khapra</p>
</div>

    
  </div>
</section>



<!-- Projects Section -->
<section id="projects" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-6 text-center gradient-text tracking-tight uppercase">Featured Projects</h2>
  
  <!-- Project Filter Buttons -->
  <div class="flex justify-center gap-4 mb-12 flex-wrap px-6">
    <button class="filter-btn active px-6 py-2 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-400 font-semibold transition hover:bg-blue-500 hover:text-white" data-filter="all">All Projects</button>
    <button class="filter-btn px-6 py-2 rounded-full border border-blue-500/30 bg-white/5 text-gray-400 font-semibold transition hover:bg-blue-500 hover:text-white" data-filter="java">Java / Backend</button>
    <button class="filter-btn px-6 py-2 rounded-full border border-blue-500/30 bg-white/5 text-gray-400 font-semibold transition hover:bg-blue-500 hover:text-white" data-filter="web">Full Stack Web</button>
    <button class="filter-btn px-6 py-2 rounded-full border border-blue-500/30 bg-white/5 text-gray-400 font-semibold transition hover:bg-blue-500 hover:text-white" data-filter="ai">AI / ML</button>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 px-6" id="projects-container">
    @forelse($projects as $project)
      <!-- Dynamic Project Card -->
      <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 project-item" data-category="{{ strtolower($project->category ?? 'web') }}">
        @if($project->image)
          <img src="{{ $project->image }}" class="w-full h-48 object-cover rounded-2xl mb-6 border border-white/5">
        @endif
        <h3 class="text-2xl font-bold mb-3 text-blue-600">{{ $project->title }}</h3>
        <p class="text-slate-400 mb-4">{{ $project->description }}</p>
        @if($project->link)
          <a href="{{ $project->link }}" target="_blank" class="text-blue-500 font-semibold hover:underline">View Project &rarr;</a>
        @endif
      </div>

    @empty
      <!-- Fallback / Hardcoded Projects if DB is empty -->
      <div class="card p-8 rounded-3xl backdrop-blur-md shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 project-item" data-category="java">
        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800" class="w-full h-48 object-cover rounded-2xl mb-6 border border-white/5 opacity-80">
        <h3 class="text-2xl font-bold mb-3 text-blue-600">Car Showroom Management System</h3>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-bold uppercase">Java</span>
          <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-bold uppercase">MySQL</span>
        </div>
        <p class="text-slate-400 mb-4">Built a high-performance web-based application for remote car inventory management using Java and MySQL databases.</p>
      </div>
      
      <div class="card p-8 rounded-3xl backdrop-blur-md shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 project-item" data-category="ai">
        <img src="https://images.unsplash.com/photo-1555255707-c07966488a7b?auto=format&fit=crop&q=80&w=800" class="w-full h-48 object-cover rounded-2xl mb-6 border border-white/5 opacity-80">
        <h3 class="text-2xl font-bold mb-3 text-purple-600">Sign Language Recognition</h3>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-xs font-bold uppercase">Python</span>
          <span class="bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-xs font-bold uppercase">OpenCV</span>
        </div>
        <p class="text-slate-400 mb-4">Real-time computer vision system that translates hand gestures into text using machine learning and OpenCV.</p>
      </div>

    @endforelse
  </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-20 section-bg overflow-hidden">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Testimonials</h2>
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex gap-8 testimonials-track">
      <!-- Testimonial 1 -->
      <div class="min-w-[350px] md:min-w-[450px] card p-8 rounded-3xl border-blue-500/20">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl">MK</div>
          <div>
            <h4 class="text-lg font-bold text-gray-200">Manoj Kumar</h4>
            <p class="text-sm text-blue-500">Senior Project Manager</p>
          </div>
        </div>
        <p class="text-gray-400 italic font-medium leading-relaxed">"Mukesh is an exceptional developer. His ability to solve complex backend problems while maintaining a clean frontend is truly rare."</p>
      </div>
      
      <!-- Testimonial 2 -->
      <div class="min-w-[350px] md:min-w-[450px] card p-8 rounded-3xl border-purple-500/20">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-xl">AS</div>
          <div>
            <h4 class="text-lg font-bold text-gray-200">Anjali Sharma</h4>
            <p class="text-sm text-purple-500">Tech Lead</p>
          </div>
        </div>
        <p class="text-gray-400 italic font-medium leading-relaxed">"Working with Mukesh was a breeze. He delivered the Sign Language project ahead of schedule with near-perfect accuracy."</p>
      </div>

      <!-- Testimonial 3 -->
      <div class="min-w-[350px] md:min-w-[450px] card p-8 rounded-3xl border-green-500/20">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-xl">RV</div>
          <div>
            <h4 class="text-lg font-bold text-gray-200">Rahul Verma</h4>
            <p class="text-sm text-green-500">Startup Founder</p>
          </div>
        </div>
        <p class="text-gray-400 italic font-medium leading-relaxed">"His grasp of Java and Full-Stack technologies helped us scale our MVP in recorded time. Highly recommended!"</p>
      </div>
    </div>
  </div>
</section>


<!-- Services Section -->
<section id="services" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Services & Offerings</h2>

  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-6">

    <!-- Freelancing Services -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 hover:scale-105 card">

      <h3 class="text-2xl font-bold mb-4 text-blue-600">Freelancing</h3>
      <p class="text-slate-400 mb-4">I offer freelance services in Java development, full-stack web development, and software solutions. Whether it's building custom applications, optimizing existing code, or integrating new technologies, I'm here to help bring your ideas to life.</p>
      <ul class="list-disc list-inside text-slate-400 space-y-1">
        <li>Custom Java Applications</li>
        <li>Web Development (Frontend & Backend)</li>
        <li>Database Design & Optimization</li>
        <li>API Development & Integration</li>
      </ul>
    </div>

    <!-- Business Growth Consultation -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 hover:scale-105 card">

      <h3 class="text-2xl font-bold mb-4 text-green-600">Business Growth</h3>
      <p class="text-slate-400 mb-4">Discuss strategies for scaling your business through technology. From digital transformation to process automation, I can provide insights on leveraging tech for sustainable growth and competitive advantage.</p>
      <ul class="list-disc list-inside text-slate-400 space-y-1">
        <li>Digital Transformation Strategies</li>
        <li>Process Automation Solutions</li>
        <li>Technology Roadmap Planning</li>
        <li>Startup Growth Consulting</li>
      </ul>
    </div>

    <!-- Technology Growth & Innovation -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 hover:scale-105 card">

      <h3 class="text-2xl font-bold mb-4 text-purple-600">Technology Growth</h3>
      <p class="text-slate-400 mb-4">Stay ahead of the curve with emerging technologies. I can help you explore AI, machine learning, cloud computing, and other cutting-edge technologies to drive innovation and future-proof your operations.</p>
      <ul class="list-disc list-inside text-slate-400 space-y-1">
        <li>AI & Machine Learning Integration</li>
        <li>Cloud Migration & Optimization</li>
        <li>Emerging Tech Research</li>
        <li>Tech Innovation Workshops</li>
      </ul>
    </div>

  </div>

  <!-- Call to Action -->
  <div class="text-center mt-12">
    <p class="text-lg text-slate-400 mb-6">Ready to discuss your project or explore new opportunities?</p>
    <a href="#contact" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition">Let's Talk</a>
  </div>
</section>


<!-- Contact Section -->
<section id="contact" class="py-20 section-bg">
  <h2 class="text-4xl font-extrabold mb-14 text-center gradient-text tracking-tight uppercase">Contact Me</h2>

  @if(session('success'))
    <div class="max-w-2xl mx-auto mb-10 p-6 bg-blue-500/20 border border-blue-500/50 backdrop-blur-xl text-blue-400 rounded-2xl text-center font-bold animate-bounce">
      {{ session('success') }}
    </div>
  @endif

  <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 px-6">

    <!-- Contact Form -->
    <div class="p-8 rounded-3xl backdrop-blur-md shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <h3 class="text-2xl font-bold mb-6 text-blue-600">Send a Message</h3>
      <form action="{{ route('contact.post') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-slate-400 font-medium mb-2">Name</label>
          <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Purpose</label>
          <select name="purpose" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select Purpose</option>
            <option value="general" {{ old('purpose') == 'general' ? 'selected' : '' }}>General Inquiry</option>
            <option value="freelancing" {{ old('purpose') == 'freelancing' ? 'selected' : '' }}>Freelancing Project</option>
            <option value="business" {{ old('purpose') == 'business' ? 'selected' : '' }}>Business Growth Discussion</option>
            <option value="technology" {{ old('purpose') == 'technology' ? 'selected' : '' }}>Technology Consultation</option>
          </select>
          @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Message</label>
          <textarea name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
          @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition">Send Message</button>
      </form>
    </div>

    <!-- Request Callback Form -->
    <div class="p-8 rounded-3xl backdrop-blur-md shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 card">

      <h3 class="text-2xl font-bold mb-6 text-green-600">Request a Callback</h3>
      <form action="{{ route('callback.post') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-slate-400 font-medium mb-2">Name</label>
          <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
          @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Phone</label>
          <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
          @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
          @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Purpose</label>
          <select name="purpose" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">Select Purpose</option>
            <option value="general" {{ old('purpose') == 'general' ? 'selected' : '' }}>General Inquiry</option>
            <option value="freelancing" {{ old('purpose') == 'freelancing' ? 'selected' : '' }}>Freelancing Project</option>
            <option value="business" {{ old('purpose') == 'business' ? 'selected' : '' }}>Business Growth Discussion</option>
            <option value="technology" {{ old('purpose') == 'technology' ? 'selected' : '' }}>Technology Consultation</option>
          </select>
          @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block text-slate-400 font-medium mb-2">Message (Optional)</label>
          <textarea name="message" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('message') }}</textarea>
          @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg font-semibold hover:bg-green-600 transition">Request Callback</button>
      </form>
    </div>

  </div>

  <!-- Contact Info -->
  <div class="max-w-2xl mx-auto mt-10 p-8 rounded-3xl backdrop-blur-md shadow-2xl card border-blue-500/30">

    <div class="flex flex-col gap-4 text-center mb-6">
      <p class="text-slate-400 text-lg"><span class="font-semibold">Email:</span> mukeshrk2003@gmail.com</p>
      <p class="text-slate-400 text-lg"><span class="font-semibold">Phone:</span> <a href="tel:+917762019563" class="text-blue-500 hover:underline">+91 77620 19563</a></p>
      <p class="text-slate-400 text-lg"><span class="font-semibold">Location:</span> Bengaluru, India</p>
    </div>

    <!-- Social Links -->
    <div class="flex justify-center flex-wrap gap-4">
      <a href="https://www.linkedin.com/in/mukeshkumarray360/" target="_blank" class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition">LinkedIn</a>
      <a href="https://github.com/mkr001" target="_blank" class="px-5 py-2 rounded-full bg-gray-100 text-gray-800 font-medium hover:bg-gray-200 transition">GitHub</a>
      <a href="mailto:mukeshrk2003@gmail.com" class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-medium hover:bg-green-200 transition">Send Email</a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="py-10 text-center border-t border-white/5 opacity-50 hover:opacity-100 transition">
    <p class="text-gray-500 text-sm">&copy; 2026 Mukesh Kumar Ray. All rights reserved.</p>
    <a href="{{ route('admin.dashboard') }}" class="text-[10px] text-gray-800 mt-2 inline-block hover:text-blue-500">Admin Login</a>
</footer>

<!-- Scripts -->

<script>
  gsap.registerPlugin(ScrollTrigger);

  // 1. Premium Preloader Logic
  window.addEventListener('load', () => {
    let progress = 0;
    const preloaderText = document.getElementById('preloader-text');
    const preloaderBar = document.getElementById('preloader-bar');
    const preloader = document.getElementById('preloader');
    
    const interval = setInterval(() => {
      progress += Math.floor(Math.random() * 10) + 2;
      if (progress >= 100) {
        progress = 100;
        clearInterval(interval);
        
        // GSAP Preloader Exit
        const tl = gsap.timeline();
        tl.to(preloaderText, { y: -50, opacity: 0, duration: 0.5, delay: 0.2 })
          .to(preloader, { 
            clipPath: 'polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%)', 
            duration: 1, 
            ease: "power4.inOut" 
          })
          .from("#home h1, #home p, #home .space-x-4", { 
            y: 100, opacity: 0, stagger: 0.2, duration: 1, ease: "power3.out" 
          }, "-=0.5");
      }
      preloaderText.textContent = progress + '%';
      preloaderBar.style.width = progress + '%';
    }, 50);
  });

  // 2. Mouse Follower
  const cursor = document.getElementById('cursor');
  const follower = document.getElementById('cursor-follower');
  
  document.addEventListener('mousemove', (e) => {
    gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0 });
    gsap.to(follower, { x: e.clientX - 10, y: e.clientY - 10, duration: 0.3 });
  });

  document.querySelectorAll('a, button, select, input, textarea, .card').forEach(el => {
    el.addEventListener('mouseenter', () => {
      gsap.to(cursor, { scale: 3, opacity: 0.5 });
      gsap.to(follower, { scale: 1.5, borderColor: '#60a5fa' });
    });
    el.addEventListener('mouseleave', () => {
      gsap.to(cursor, { scale: 1, opacity: 1 });
      gsap.to(follower, { scale: 1, borderColor: '#3b82f6' });
    });
  });

  // 3. Project Filtering Logic
  const filterBtns = document.querySelectorAll('.filter-btn');
  const projectItems = document.querySelectorAll('.project-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // Update buttons
      filterBtns.forEach(b => b.classList.remove('active', 'bg-blue-500/10', 'text-blue-400'));
      filterBtns.forEach(b => b.classList.add('bg-white/5', 'text-gray-400'));
      btn.classList.add('active', 'bg-blue-500/10', 'text-blue-400');
      btn.classList.remove('bg-white/5', 'text-gray-400');

      const filter = btn.getAttribute('data-filter');
      
      // Animate cards
      gsap.to(projectItems, {
        scale: 0.8,
        opacity: 0,
        duration: 0.3,
        onComplete: () => {
          projectItems.forEach(item => {
            if (filter === 'all' || item.getAttribute('data-category') === filter) {
              item.style.display = 'block';
              gsap.to(item, { scale: 1, opacity: 1, duration: 0.5, ease: "back.out(1.7)" });
            } else {
              item.style.display = 'none';
            }
          });
          ScrollTrigger.refresh();
        }
      });
    });
  });

  // 4. Testimonials Marquee Animation
  const track = document.querySelector('.testimonials-track');
  if(track) {
    const trackWidth = track.scrollWidth;
    gsap.to(track, {
      x: () => -(trackWidth - window.innerWidth),
      ease: "none",
      scrollTrigger: {
        trigger: "#testimonials",
        start: "top center",
        end: "bottom top",
        scrub: 1,
        invalidateOnRefresh: true
      }
    });
  }

  // 5. Section reveals
  gsap.utils.toArray('section').forEach(section => {
    const header = section.querySelector('h2');
    if(header) {
      gsap.fromTo(header, 
        { scale: 0.9, opacity: 0 },
        { 
          scale: 1, opacity: 1, duration: 1,
          scrollTrigger: { trigger: header, start: "top 90%" }
        }
      );
    }
    gsap.fromTo(section, 
      { opacity: 0, y: 50 },
      { 
        opacity: 1, y: 0, duration: 1, 
        scrollTrigger: {
          trigger: section,
          start: "top 80%",
          toggleActions: "play none none none"
        }
      }
    );
  });

  // 6. Typing effect
  const texts = ["Java Developer", "Full Stack Developer", "Open Source Enthusiast", "Problem Solver"];
  let count = 0, index = 0, currentText = '', isDeleting = false, letter = '';
  (function type(){
    if(count === texts.length) count = 0;
    currentText = texts[count];
    if(!isDeleting) letter = currentText.slice(0, ++index);
    else letter = currentText.slice(0, --index);
    document.getElementById('typing').textContent = letter;
    let typeSpeed = isDeleting ? 100 : 200;
    if(!isDeleting && letter.length === currentText.length) { typeSpeed = 2000; isDeleting = true; }
    else if(isDeleting && letter.length === 0) { isDeleting = false; count++; typeSpeed = 500; }
    setTimeout(type, typeSpeed);
  }());

  // 7. Skills animation
  document.querySelectorAll('.skill-bar').forEach(bar => {
    const percent = bar.getAttribute('data-percent');
    gsap.to(bar, { 
      width: percent + '%', duration: 1.5, ease: "power2.out",
      scrollTrigger: { trigger: bar, start: "top 90%" }
    });
  });

  // 8. Back to top logic
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
      gsap.to(backToTop, { opacity: 1, pointerEvents: 'auto', duration: 0.3 });
    } else {
      gsap.to(backToTop, { opacity: 0, pointerEvents: 'none', duration: 0.3 });
    }
  });
  backToTop.addEventListener('click', () => {
    gsap.to(window, { scrollTo: 0, duration: 1, ease: "power3.inOut" });
  });
</script>

</body>
</html>