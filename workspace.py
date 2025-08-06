import webview
import time

inject_js = """
console.log("Injecting search bar...");

setTimeout(function() {
    // Enable text selection + visibility
    var css = `
        * { user-select: text !important; -webkit-user-select: text !important; }
        #customSearchBar.noHide {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    `;
    var style = document.createElement('style');
    style.type = 'text/css';
    style.appendChild(document.createTextNode(css));
    document.head.appendChild(style);

    // Add search bar
    if (!document.getElementById('customSearchBar')) {
        var input = document.createElement('input');
        input.id = 'customSearchBar';
        input.className = 'noHide';
        input.placeholder = 'Search...';
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
        input.style.setProperty('display', 'block', 'important');
        input.style.setProperty('visibility', 'visible', 'important');
        input.style.setProperty('opacity', '1', 'important');

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                var text = input.value;
                window.find(text);
            }
        });

        document.body.appendChild(input);
    }
}, 1000);  // 1 second delay
"""

def inject_later():
    time.sleep(3)
    result = webview.windows[0].evaluate_js(inject_js)
    print("JS injection result:", result)

webview.create_window(
    "My Website",
    "https://yousab-tech.com/workspace/public/en",
    width=1000,
    height=800
)

webview.start(func=inject_later)
