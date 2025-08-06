import webview

# JavaScript to force-enable text selection
enable_selection_js = """
document.addEventListener('DOMContentLoaded', function() {
    var css = '* { user-select: text !important; -webkit-user-select: text !important; }';
    var style = document.createElement('style');
    style.type = 'text/css';
    style.appendChild(document.createTextNode(css));
    document.head.appendChild(style);
});
"""

# Create a window with the JS injected
webview.create_window(
    "My Website",
    "https://yousab-tech.com/workspace/public/en",
    js_api=None,
    width=1000,
    height=800,
    on_top=False,
    confirm_close=False,
    text_select=True  # Optional, works in some backends
)

# Start with JS injected after window is loaded
webview.start(func=lambda: webview.windows[0].evaluate_js(enable_selection_js))
