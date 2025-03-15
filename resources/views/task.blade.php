<!DOCTYPE html>
<html lang="en">
<head>
    @component('header')
    @endcomponent
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('resources/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/task.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
</head>
<body>
    <div class="sidebar-overlay"></div>
    <div class="sticky-top" id="temp-body"></div>
    @component('head', ['title' => 'Tasks'])
    @endcomponent
    @component('sidebar', [
        'home' => '',
        'message' => '',
        'discovery' => '',
        'project' => '',
        'task' => 'active'
    ])
    @endcomponent

    <div class="main-content">
        <div class="task-container">
            <div class="problem-section">
                <h2 class="mobile-title">Problem Statement</h2>
                <div class="problem-content">
                    <h3>Two Sum</h3>
                    <p>Given an array of integers nums and an integer target, return indices of the two numbers such that they add up to target.</p>
                    <div class="example">
                        <h4>Example:</h4>
                        <pre>Input: nums = [2,7,11,15], target = 9
Output: [0,1]
Explanation: Because nums[0] + nums[1] == 9, we return [0, 1].</pre>
                    </div>
                </div>
            </div>
            
            <div class="code-section">
                <div class="language-selector">
                    <select id="language-select" class="mobile-select">
                        <option value="54">C++ (GCC 9.2.0)</option>
                        <option value="62">Java (OpenJDK 13.0.1)</option>
                        <option value="71">Python (3.8.1)</option>
                        <option value="63">JavaScript (Node.js 12.14.0)</option>
                    </select>
                    <button id="run-btn" class="run-button mobile-button">
                        <i class="fas fa-play"></i> Run
                    </button>
                </div>
                <div id="editor"></div>
                
                <div class="io-section">
                    <div class="input-section">
                        <h4>Input:</h4>
                        <textarea id="input" placeholder="Enter your test input here..."></textarea>
                    </div>
                    <div class="output-section">
                        <h4>Output:</h4>
                        <pre id="output"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/python/python.min.js"></script>
    <script src="{{ asset('resources/js/task.js') }}"></script>
    <script src="{{ asset('resources/js/sidebar.js') }}"></script>

</body>
</html>
