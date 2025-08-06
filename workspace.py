import webview

# JavaScript to inject a search bar and enable text selection
inject_js = """
document.addEventListener('DOMContentLoaded', function() {
    // Enable text selection
    var css = '* { user-select: text !important; -webkit-user-select: text !important; }';
    var style = document.createElement('style');
    style.type = 'text/css';
    style.appendChild(document.createTextNode(css));
    document.head.appendChild(style);

    // Create search bar
    if (!document.getElementById('customSearchBar')) {
        var input = document.createElement('input');
        input.id = 'customSearchBar';
        input.placeholder = 'Search... (like Ctrl+F)';
        input.className = 'noHide';  // <- Required class
        input.style.position = 'fixed';
        input.style.top = '10px';
        input.style.right = '10px';
        input.style.zIndex = '9999';
        input.style.padding = '5px';
        input.style.borderRadius = '5px';
        input.style.border = '1px solid #ccc';
        input.style.backgroundColor = '#fff';
        input.style.fontSize = '14px';
        input.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';

        // Search on Enter
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                var text = input.value;
                window.find(text);
            }
        });

        document.body.appendChild(input);
    }
});
"""

# Create the window
webview.create_window(
    "My Website",
    "https://yousab-tech.com/workspace/public/en",
    width=1000,
    height=800
)

# Start and inject JS after load
webview.start(func=lambda: webview.windows[0].evaluate_js(inject_js))
