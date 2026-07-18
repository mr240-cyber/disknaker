import re
import sys

def replace_style(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    new_content = re.sub(r'<style>.*?</style>', '<link rel=\"stylesheet\" href=\"{{ asset(\\\'css/modern-design.css\\\') }}\">', content, flags=re.DOTALL)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print(f'Replaced inline style with external link in {filepath}')

replace_style('resources/views/welcome.blade.php')
