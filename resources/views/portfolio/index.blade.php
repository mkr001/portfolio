<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mukesh Kumar Ray | Portfolio</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  html { scroll-behavior: smooth; }
  body { font-family: 'Roboto', sans-serif; background-color: #f3f4f6; color: #111827; }

  /* Gradient for all sections */
.section-bg {
  background: linear-gradient(135deg,#a7f3d0,#60a5fa); /* light green + blue */
}


  section { opacity: 0; transform: translateY(40px); transition: all 1s ease-out; }
  section.show { opacity: 1; transform: translateY(0); }

  .skill-bar { width: 0; transition: width 1.5s ease-in-out; }
  .typing-text { border-right: 2px solid #3b82f6; white-space: nowrap; overflow: hidden; display:inline-block; }

  /* Navbar background */
  nav { background-color: rgba(255,255,255,0.8); backdrop-filter: blur(10px); }

  /* Card shadow effect */
  .card { background: #ffffffaa; backdrop-filter: blur(10px); }
</style>
</head>
<body>

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
<section id="about" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-extrabold mb-10 text-blue-600 text-center tracking-wide">About Me</h2>
  
  <div class="max-w-6xl mx-auto px-6 rounded-2xl shadow-2xl space-y-6 text-center md:text-left">
    <p class="text-lg text-gray-700 leading-relaxed">
      I am a <span class="font-semibold text-blue-600">passionate and detail-oriented developer</span> with strong expertise in 
      <span class="font-semibold">Java web development</span> and solid command over both 
      <span class="font-semibold">frontend and backend technologies</span>. 
      I thrive in environments that foster <span class="italic">creativity, innovation, and continuous learning</span>, while contributing meaningfully to organizational growth.
    </p>
    <p class="text-lg text-gray-700 leading-relaxed">
      My skill set includes <span class="font-semibold">Java, PHP, Laravel, React.js, Node.js, and MySQL</span>, along with modern frameworks 
      like <span class="font-semibold">Tailwind CSS</span> and <span class="font-semibold">Bootstrap</span>.  
      I am proficient in <span class="font-semibold">Collection Frameworks, JDBC, and Git</span>, and I have hands-on experience with industry-standard tools 
      such as <span class="font-semibold">Eclipse, VS Code, and JDK</span>.
    </p>
    <p class="text-lg text-gray-700 leading-relaxed">
      With a strong foundation in problem-solving and application development, 
      I aim to build <span class="font-semibold text-blue-600">scalable, efficient, and user-friendly solutions</span> that make a real impact.
    </p>
  </div>
</section>

<!-- Experience Section -->
<section id="experience" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-extrabold text-center mb-14 text-blue-600 tracking-wide">Experience</h2>
  
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      
      <!-- Card 1 -->
      <div class="card p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-transform duration-300 hover:-translate-y-2">
        <div class="flex items-center gap-3 mb-3">
          <img src="/images/quality.png" alt="Quality Austria Logo" class="w-10 h-10 object-contain">
          <h3 class="text-2xl font-semibold text-blue-600">Quality Analyst</h3>
        </div>
        <p class="text-lg text-gray-800 font-medium">
          <a href="https://www.qualityaustriacentralasia.com/" target="_blank" rel="noopener noreferrer">Quality Austria Central Asia Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Oct 2024 – Feb 2025 | Bengaluru, India</p>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
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
        <p class="text-lg text-gray-800 font-medium">
          <a href="https://www.rmsi.com/" target="_blank" rel="noopener noreferrer">RMSI Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Jun 2024 – Aug 2024 | Noida, India</p>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
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
        <p class="text-lg text-gray-800 font-medium">
          <a href="https://merums.com/" target="_blank" rel="noopener noreferrer">Merums Shared Services Pvt Ltd</a>
        </p>
        <p class="text-gray-500 mb-4">Feb 2025 – Present | Delhi, India</p>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
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
<section id="skills" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-bold text-center mb-10 text-blue-500">Technical Skills</h2>
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6">
    <!-- Skill Bars -->
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>PHP</span><span>85%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 h-5 rounded-full skill-bar" data-percent="85"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>Laravel</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-green-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>HTML/CSS/JS</span><span>90%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-yellow-400 via-red-400 to-pink-500 h-5 rounded-full skill-bar" data-percent="90"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>React.js</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-teal-400 to-green-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>Bootstrap/Tailwind CSS</span><span>85%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 h-5 rounded-full skill-bar" data-percent="85"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>Node.js</span><span>75%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-green-400 via-lime-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="75"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>MySQL</span><span>80%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-red-400 via-orange-400 to-yellow-400 h-5 rounded-full skill-bar" data-percent="80"></div></div>
    </div>
    <div><div class="flex justify-between mb-1 font-semibold text-gray-700"><span>Java</span><span>90%</span></div>
      <div class="w-full bg-gray-300 h-5 rounded-full overflow-hidden"><div class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 h-5 rounded-full skill-bar" data-percent="90"></div></div>
    </div>
  </div>
</section>

<!-- Education Section -->
<section id="education" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-bold text-center mb-14 text-blue-500 tracking-wide">Education</h2>
  
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
    
    <!-- B.Tech Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 bg-gradient-to-tr from-white/70 to-blue-50/50 backdrop-blur-md border-l-8 border-blue-500">
      <h3 class="text-2xl font-bold mb-3 text-blue-600">B.Tech in CSE</h3>
      <p class="text-gray-700 mb-1 font-medium">
        <a href="https://ptu.ac.in//" target="_blank" class="text-blue-600 hover:underline">I.K. Gujral Punjab Technical University, Jalandhar</a>
      </p>
      <p class="text-gray-500">Graduated: 2024 | Location: Punjab, India</p>
    </div>
    
    <!-- 12th Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 bg-gradient-to-tr from-white/70 to-green-50/50 backdrop-blur-md border-l-8 border-green-500">
      <h3 class="text-2xl font-bold mb-3 text-green-600">12th - Science</h3>
      <p class="text-gray-700 mb-1 font-medium">
        <a href="http://biharboardonline.bihar.gov.in/" target="_blank" class="text-green-600 hover:underline">Bihar School Examination Board</a>
      </p>
      <p class="text-gray-500">Year: 2020 | Location: Bihar, India</p>
    </div>
    
    <!-- 10th Card -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 bg-gradient-to-tr from-white/70 to-yellow-50/50 backdrop-blur-md border-l-8 border-yellow-500">
      <h3 class="text-2xl font-bold mb-3 text-yellow-600">10th</h3>
      <p class="text-gray-700 mb-1 font-medium">
        <a href="http://biharboardonline.bihar.gov.in/" target="_blank" class="text-yellow-600 hover:underline">Bihar School Examination Board</a>
      </p>
      <p class="text-gray-500">Year: 2018 | Location: Bihar, India</p>
    </div>
    
  </div>
</section>

<!-- Training & Certification Section -->
<section id="training" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-bold text-center mb-14 text-blue-500 tracking-wide">Training & Certifications</h2>
  
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6">
    
    <!-- Training 1: QSpiders Java Full Stack -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 bg-gradient-to-tr from-white/70 to-blue-50/50 backdrop-blur-md border-l-8 border-blue-500">
      <div class="flex items-center mb-4">
        <img src="/images/qsp.png" alt="QSpiders Logo" class="w-12 h-12 object-contain mr-3">
        <h3 class="text-2xl font-bold text-blue-600">Java Full Stack Training</h3>
      </div>
      <p class="text-gray-700 mb-1 font-medium">
        <a href="https://www.qspiders.com/" target="_blank" class="text-blue-600 hover:underline">QSpiders, Noida</a>
      </p>
      <p class="text-gray-500">2024 | Core Java, HTML, CSS, MySQL, React.js | IDEs: Eclipse, VS Code | Tools: Git, GitHub</p>
    </div>
    
    <!-- Training 2: Apna College Java + DSA -->
<div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 bg-gradient-to-tr from-white/70 to-purple-50/50 backdrop-blur-md border-l-8 border-purple-500">
  <div class="flex flex-col items-center mb-4">
    <img src="/images/apana.png" alt="Apna College Logo" class="w-20 h-auto object-contain mb-3">
    <h3 class="text-2xl font-bold text-purple-600 text-center">Java + DSA Training</h3>
  </div>
  <p class="text-gray-700 mb-1 font-medium text-center">
    <a href="https://www.apnacollege.in/course/placement-course-java" target="_blank" class="text-purple-600 hover:underline">Apna College</a>
  </p>
  <p class="text-gray-500 text-center">2024 | Java Programming, Data Structures & Algorithms | 400+ Lectures, 300+ Coding Questions | Instructor: Shradha Khapra</p>
</div>

    
  </div>
</section>



<!-- Projects Section -->
<section id="projects" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-bold mb-14 text-center text-blue-500 tracking-wide">Projects</h2>
  
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 px-6">
    
    <!-- Project Card 1 -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 hover:scale-105 bg-gradient-to-tr from-white/70 to-blue-50/50 backdrop-blur-md border-l-8 border-blue-500">
      <h3 class="text-2xl font-bold mb-3 text-blue-600">Car Showroom Management System</h3>
      <div class="flex flex-wrap gap-3 mb-4">
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">Role: Developer</span>
        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Tech: Java, MySQL</span>
      </div>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Built a <span class="font-semibold">web-based application</span> for remote car management.</li>
        <li>Implemented backend services using <span class="font-semibold">Java and MySQL</span>.</li>
        <li>Optimized data handling using <span class="font-semibold">Collection Frameworks</span>.</li>
        <li>Designed <span class="font-semibold">user-friendly UI</span> for better customer experience.</li>
        <li>Version control via <span class="font-semibold">GitHub</span>.</li>
      </ul>
    </div>
    
    <!-- Project Card 2 -->
    <div class="card p-8 rounded-3xl shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3 hover:scale-105 bg-gradient-to-tr from-white/70 to-purple-50/50 backdrop-blur-md border-l-8 border-purple-500">
      <h3 class="text-2xl font-bold mb-3 text-purple-600">Sign Language Recognition System</h3>
      <div class="flex flex-wrap gap-3 mb-4">
        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">Role: Developer</span>
        <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-medium">Tech: Python, OpenCV, ML</span>
      </div>
      <ul class="list-disc list-inside text-gray-700 space-y-2">
        <li>Real-time sign language detection using <span class="font-semibold">computer vision</span>.</li>
        <li>Trained ML models to recognize <span class="font-semibold">hand gestures</span>.</li>
        <li>Created web interface to translate gestures into <span class="font-semibold">text</span>.</li>
        <li>Improved accuracy with <span class="font-semibold">data preprocessing and augmentation</span>.</li>
        <li>Used <span class="font-semibold">Git</span> for version control.</li>
      </ul>
    </div>
    
  </div>
</section>


<!-- Contact Section -->
<section id="contact" class="py-20 section-bg" data-aos="fade-up">
  <h2 class="text-4xl font-bold mb-14 text-center text-blue-500 tracking-wide">Contact Me</h2>
  
  <div class="max-w-2xl mx-auto p-8 rounded-3xl bg-gradient-to-tr from-white/70 to-blue-50/50 backdrop-blur-md shadow-2xl hover:shadow-3xl transition-transform transform hover:-translate-y-3">
    
    <!-- Contact Info -->
    <div class="flex flex-col gap-4 text-center mb-6">
      <p class="text-gray-700 text-lg"><span class="font-semibold">Email:</span> mukeshrk2003@gmail.com</p>
      <p class="text-gray-700 text-lg"><span class="font-semibold">Phone:</span> +91 77620 19563</p>
      <p class="text-gray-700 text-lg"><span class="font-semibold">Location:</span> Bengaluru, India</p>
    </div>
    
    <!-- Social Links -->
    <div class="flex justify-center flex-wrap gap-4 mb-6">
      <a href="https://www.linkedin.com/in/mukeshkumarray360/" target="_blank" class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition">LinkedIn</a>
      <a href="https://github.com/mkr001" target="_blank" class="px-5 py-2 rounded-full bg-gray-100 text-gray-800 font-medium hover:bg-gray-200 transition">GitHub</a>
      <a href="mailto:mukeshrk2003@gmail.com" class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-medium hover:bg-green-200 transition">Send Email</a>
    </div>
    
    <!-- Optional Message Button / Form -->
    <div class="text-center">
      <a href="mailto:mukeshrk2003@gmail.com" class="bg-blue-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-600 transition">Contact Me</a>
    </div>
    

  </div>
</section>




<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000 });

  // Typing effect
  const texts = ["Java Developer", "Full Stack Developer", "Open Source Enthusiast", "Problem Solver"];
  let count = 0, index = 0, currentText = '', letter = '';
  (function type(){
    if(count === texts.length) count = 0;
    currentText = texts[count];
    letter = currentText.slice(0, ++index);
    document.getElementById('typing').textContent = letter;
    if(letter.length === currentText.length){ count++; index = 0; setTimeout(type,1000);}
    else setTimeout(type,150);
  }());

  // Skills animation
  const skillBars = document.querySelectorAll('.skill-bar');
  window.addEventListener('scroll', ()=>{
    skillBars.forEach(bar=>{
      const percent = bar.getAttribute('data-percent');
      const top = bar.getBoundingClientRect().top;
      const height = window.innerHeight;
      if(top < height){
        bar.style.width = percent + '%';
      }
    });
  });

  // Smooth section show animation
  const sections = document.querySelectorAll('section');
  window.addEventListener('scroll', () => {
    sections.forEach(sec=>{
      const top = sec.getBoundingClientRect().top;
      const height = window.innerHeight;
      if(top < height - 100){ sec.classList.add('show'); }
    });
  });
</script>
</body>
</html>
