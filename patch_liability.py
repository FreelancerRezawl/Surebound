import re

with open('resources/views/liability-insurance.blade.php', 'r') as f:
    content = f.read()

content = content.replace("['property-insurance']", "['liability-insurance']")
content = content.replace("$content['hero_image'] ?? 'images/hero-house.jpg'", "$content['hero_image'] ?? 'images/hero-business.jpg'")
content = content.replace("property-insurance", "liability-insurance")

with open('resources/views/liability-insurance.blade.php', 'w') as f:
    f.write(content)
