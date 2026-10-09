import re

with open('app/Http/Controllers/AdminController.php', 'r') as f:
    content = f.read()

# 1. Duplicate getDefaultLiabilityInsuranceContent
content_match = re.search(r'(    public static function getDefaultLiabilityInsuranceContent\(\): array\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if content_match:
    liability_content_method = content_match.group(1)
    
    group_content_method = liability_content_method.replace('getDefaultLiabilityInsuranceContent', 'getDefaultGroupBenefitsContent')
    group_content_method = group_content_method.replace('images/hero-specialty.jpg', 'images/hero-family.jpg')
    group_content_method = group_content_method.replace('COMMERCIAL LIABILITY INSURANCE', 'WORKERS COMPENSATION & BENEFITS')
    group_content_method = group_content_method.replace('Protection Built Around<br>Your Business', 'Taking Care of<br>Your Team')
    group_content_method = group_content_method.replace('liability', 'group benefits')
    
    content = content[:content_match.end()] + "\n" + group_content_method + content[content_match.end():]
else:
    print("Could not find getDefaultLiabilityInsuranceContent")

# 2. Duplicate showLiabilityInsurance
show_match = re.search(r'(    public function showLiabilityInsurance\(\)\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if show_match:
    liability_show_method = show_match.group(1)
    
    group_show_method = liability_show_method.replace('showLiabilityInsurance', 'showGroupBenefits')
    group_show_method = group_show_method.replace("'liability-insurance'", "'group-benefits'")
    group_show_method = group_show_method.replace('getDefaultLiabilityInsuranceContent', 'getDefaultGroupBenefitsContent')
    
    content = content[:show_match.end()] + "\n" + group_show_method + content[show_match.end():]
else:
    print("Could not find showLiabilityInsurance")

# 3. Duplicate updateLiabilityInsurance
update_match = re.search(r'(    public function updateLiabilityInsurance\(Request \$request\)\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if update_match:
    liability_update_method = update_match.group(1)
    
    group_update_method = liability_update_method.replace('updateLiabilityInsurance', 'updateGroupBenefits')
    group_update_method = group_update_method.replace("'liability-insurance'", "'group-benefits'")
    group_update_method = group_update_method.replace('Liability', 'Group Benefits')
    
    content = content[:update_match.end()] + "\n" + group_update_method + content[update_match.end():]
else:
    print("Could not find updateLiabilityInsurance")

with open('app/Http/Controllers/AdminController.php', 'w') as f:
    f.write(content)

print("Done patching AdminController.")
