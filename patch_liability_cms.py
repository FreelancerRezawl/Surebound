import re

with open('resources/views/admin/dashboard.blade.php', 'r') as f:
    content = f.read()

# 1. Insert Sidebar Link
link_match = re.search(r'(<a class="sidebar-link" data-tab="property-cms">.*?</svg>\s*<span>Property Insurance CMS</span>\s*<span class="nav-badge"[^>]*>CMS</span>\s*</a>\n)', content, flags=re.DOTALL)
if link_match:
    property_link = link_match.group(1)
    liability_link = property_link.replace('property-cms', 'liability-cms')
    liability_link = liability_link.replace('Property Insurance', 'Liability Insurance')
    # change the background/color randomly for badge if you want, but fine to keep
    content = content[:link_match.start()] + property_link + '\n' + liability_link + content[link_match.end():]
else:
    print("Could not find property-cms link to duplicate")

# 2. Insert Tab Pane
tab_match = re.search(r'(<!-- TAB X: PROPERTY INSURANCE CMS EDITOR -->.*?</div>\s*</form>\s*</div>\s*)(<!-- TAB 9: SPECIALTY COVERAGE CMS EDITOR -->)', content, flags=re.DOTALL)
if tab_match:
    property_tab = tab_match.group(1)
    
    liability_tab = property_tab.replace('TAB X: PROPERTY INSURANCE CMS EDITOR', 'TAB Y: LIABILITY INSURANCE CMS EDITOR')
    liability_tab = liability_tab.replace('tab-property-cms', 'tab-liability-cms')
    liability_tab = liability_tab.replace('propertyCmsForm', 'liabilityCmsForm')
    liability_tab = liability_tab.replace('savePropertyCms', 'saveLiabilityCms')
    liability_tab = liability_tab.replace('Property Insurance CMS Editor', 'Liability Insurance CMS Editor')
    liability_tab = liability_tab.replace('Property Insurance page (/property-insurance)', 'Liability Insurance page (/liability-insurance)')
    liability_tab = liability_tab.replace("route('property-insurance')", "route('liability-insurance')")
    liability_tab = liability_tab.replace('hero_property_', 'hero_liability_')
    liability_tab = liability_tab.replace('$propertyInsuranceContent', '$liabilityInsuranceContent')
    liability_tab = liability_tab.replace('savePropertyCmsBtn', 'saveLiabilityCmsBtn')
    liability_tab = liability_tab.replace('Publish Property Changes Live', 'Publish Liability Changes Live')

    content = content[:tab_match.start()] + property_tab + liability_tab + tab_match.group(2) + content[tab_match.end():]
else:
    print("Could not find property CMS tab to duplicate")

# 3. Duplicate savePropertyCms JS to create saveLiabilityCms JS
js_match = re.search(r'(function savePropertyCms\(e\) \{.*?\n        \}\n\n)        function saveSpecialtyCms\(e\)', content, flags=re.DOTALL)
if js_match:
    property_js = js_match.group(1)
    
    liability_js = property_js.replace('savePropertyCms', 'saveLiabilityCms')
    liability_js = liability_js.replace('propertyCmsForm', 'liabilityCmsForm')
    liability_js = liability_js.replace('savePropertyCmsBtn', 'saveLiabilityCmsBtn')
    liability_js = liability_js.replace('Publish Property Changes Live', 'Publish Liability Changes Live')
    liability_js = liability_js.replace("route('admin.property-insurance.update')", "route('admin.liability-insurance.update')")
    liability_js = liability_js.replace("Property Insurance page", "Liability Insurance page")

    content = content[:js_match.start()] + property_js + liability_js + "        function saveSpecialtyCms(e)" + content[js_match.end():]
else:
    print("Could not find property CMS JS to duplicate")

with open('resources/views/admin/dashboard.blade.php', 'w') as f:
    f.write(content)

print("Done patching.")
