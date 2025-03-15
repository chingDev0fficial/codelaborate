document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a page with editor
    const editorElement = document.getElementById('editor');
    if (editorElement && typeof CodeMirror !== 'undefined') {
        let editor = CodeMirror(editorElement, {
            mode: 'text/x-c++src',
            theme: 'dracula',
            lineNumbers: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            tabSize: 4,
            indentWithTabs: true,
            value: `// Write your code here\n`
        });

        const languageMap = {
            '54': { mode: 'text/x-c++src', template: '// Write your C++ code here\n' },
            '62': { mode: 'text/x-java', template: 'class Solution {\n    public static void main(String[] args) {\n        // Write your Java code here\n    }\n}' },
            '71': { mode: 'python', template: '# Write your Python code here\n' },
            '63': { mode: 'javascript', template: '// Write your JavaScript code here\n' }
        };

        document.getElementById('language-select').addEventListener('change', function(e) {
            const lang = languageMap[e.target.value];
            editor.setOption('mode', lang.mode);
            editor.setValue(lang.template);
        });

        document.getElementById('run-btn').addEventListener('click', async function() {
            const runBtn = this;
            const output = document.getElementById('output');
            
            runBtn.disabled = true;
            runBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';
            output.textContent = 'Executing...';

            try {
                const submission = await fetch('/execute', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        language_id: document.getElementById('language-select').value,
                        source_code: editor.getValue(),
                        stdin: document.getElementById('input').value
                    })
                });

                const { token } = await submission.json();
                
                // Poll for results
                const result = await checkStatus(token);
                
                if (result.status.id === 3) { // Accepted
                    output.textContent = base64Decode(result.stdout);
                } else {
                    output.textContent = base64Decode(result.stderr || result.compile_output);
                }
            } catch (error) {
                output.textContent = 'Error: ' + error.message;
            } finally {
                runBtn.disabled = false;
                runBtn.innerHTML = '<i class="fas fa-play"></i> Run';
            }
        });

        async function checkStatus(token) {
            let result;
            for (let i = 0; i < 10; i++) {
                const response = await fetch(`/task/result/${token}`);
                result = await response.json();
                
                if (result.status.id !== 1 && result.status.id !== 2) { // Not queued or processing
                    break;
                }
                await new Promise(resolve => setTimeout(resolve, 1000));
            }
            return result;
        }

        function base64Decode(str) {
            if (!str) return '';
            return atob(str);
        }
    }
});
