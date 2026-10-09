import re

with open('resources/views/admin/dashboard.blade.php', 'r') as f:
    content = f.read()

# 1. Duplicate tab-personal-cms to create tab-property-cms
match = re.search(r'(<!-- TAB 8: PERSONAL COVERAGE CMS EDITOR -->.*?</div>\s*</form>\s*</div>\s*)(<!-- TAB 9: SPECIALTY COVERAGE CMS EDITOR -->)', content, flags=re.DOTALL)
if match:
    personal_tab = match.group(1)
    
    # Simple replacements to make it property-cms
    property_tab = personal_tab.replace('TAB 8: PERSONAL COVERAGE CMS EDITOR', 'TAB X: PROPERTY INSURANCE CMS EDITOR')
    property_tab = property_tab.replace('tab-personal-cms', 'tab-property-cms')
    property_tab = property_tab.replace('personalCmsForm', 'propertyCmsForm')
    property_tab = property_tab.replace('savePersonalCms', 'savePropertyCms')
    property_tab = property_tab.replace('Personal Coverage CMS Editor', 'Property Insurance CMS Editor')
    property_tab = property_tab.replace('Personal &amp; Liability Coverage page (/personal-coverage)', 'Property Insurance page (/property-insurance)')
    property_tab = property_tab.replace("route('personal-coverage')", "route('property-insurance')")
    property_tab = property_tab.replace('hero_personal_', 'hero_property_')
    property_tab = property_tab.replace('$personalCoverageContent', '$propertyInsuranceContent')
    property_tab = property_tab.replace('savePersonalCmsBtn', 'savePropertyCmsBtn')
    property_tab = property_tab.replace('Publish Personal Changes Live', 'Publish Property Changes Live')

    content = content[:match.start()] + personal_tab + property_tab + match.group(2) + content[match.end():]
else:
    print("Could not find personal CMS tab to duplicate")

# 2. Duplicate savePersonalCms JS to create savePropertyCms JS
js_match = re.search(r'(function savePersonalCms\(e\) \{.*?\n        \}\n\n)        function saveSpecialtyCms\(e\)', content, flags=re.DOTALL)
if js_match:
    personal_js = js_match.group(1)
    
    property_js = personal_js.replace('savePersonalCms', 'savePropertyCms')
    property_js = property_js.replace('personalCmsForm', 'propertyCmsForm')
    property_js = property_js.replace('savePersonalCmsBtn', 'savePropertyCmsBtn')
    property_js = property_js.replace('Publish Personal Changes Live', 'Publish Property Changes Live')
    property_js = property_js.replace("route('admin.personal-coverage.update')", "route('admin.property-insurance.update')")
    property_js = property_js.replace("Personal Coverage page", "Property Insurance page")

    content = content[:js_match.start()] + personal_js + property_js + "        function saveSpecialtyCms(e)" + content[js_match.end():]
else:
    print("Could not find personal CMS JS to duplicate")

with open('resources/views/admin/dashboard.blade.php', 'w') as f:
    f.write(content)

print("Done patching.")
