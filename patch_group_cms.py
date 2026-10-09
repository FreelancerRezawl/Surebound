import re

with open('resources/views/admin/dashboard.blade.php', 'r') as f:
    content = f.read()

# 1. Insert Sidebar Link
link_match = re.search(r'(<a class="sidebar-link" data-tab="liability-cms">.*?</svg>\s*<span>Liability Insurance CMS</span>\s*<span class="nav-badge"[^>]*>CMS</span>\s*</a>\n)', content, flags=re.DOTALL)
if link_match:
    liability_link = link_match.group(1)
    group_link = liability_link.replace('liability-cms', 'group-benefits-cms')
    group_link = group_link.replace('Liability Insurance', 'Workers Compensation')
    content = content[:link_match.start()] + liability_link + group_link + content[link_match.end():]
else:
    print("Could not find liability-cms link to duplicate")

# 2. Insert Tab Pane
tab_match = re.search(r'(<!-- TAB Y: LIABILITY INSURANCE CMS EDITOR -->.*?</div>\s*</form>\s*</div>\s*)(<!-- TAB 9: SPECIALTY COVERAGE CMS EDITOR -->)', content, flags=re.DOTALL)
if tab_match:
    liability_tab = tab_match.group(1)
    
    group_tab = liability_tab.replace('TAB Y: LIABILITY INSURANCE CMS EDITOR', 'TAB Z: WORKERS COMP CMS EDITOR')
    group_tab = group_tab.replace('tab-liability-cms', 'tab-group-benefits-cms')
    group_tab = group_tab.replace('liabilityCmsForm', 'groupBenefitsCmsForm')
    group_tab = group_tab.replace('saveLiabilityCms', 'saveGroupBenefitsCms')
    group_tab = group_tab.replace('Liability Insurance CMS Editor', 'Workers Compensation CMS Editor')
    group_tab = group_tab.replace('Liability Insurance page (/liability-insurance)', 'Workers Compensation page (/group-benefits)')
    group_tab = group_tab.replace("route('liability-insurance')", "route('group-benefits')")
    group_tab = group_tab.replace('hero_liability_', 'hero_group_')
    group_tab = group_tab.replace('$liabilityInsuranceContent', '$groupBenefitsContent')
    group_tab = group_tab.replace('saveLiabilityCmsBtn', 'saveGroupBenefitsCmsBtn')
    group_tab = group_tab.replace('Publish Liability Changes Live', 'Publish Group Benefits Changes Live')

    content = content[:tab_match.start()] + liability_tab + group_tab + tab_match.group(2) + content[tab_match.end():]
else:
    print("Could not find liability CMS tab to duplicate")

# 3. Duplicate saveLiabilityCms JS to create saveGroupBenefitsCms JS
js_match = re.search(r'(function saveLiabilityCms\(e\) \{.*?\n        \}\n\n)        function saveSpecialtyCms\(e\)', content, flags=re.DOTALL)
if js_match:
    liability_js = js_match.group(1)
    
    group_js = liability_js.replace('saveLiabilityCms', 'saveGroupBenefitsCms')
    group_js = group_js.replace('liabilityCmsForm', 'groupBenefitsCmsForm')
    group_js = group_js.replace('saveLiabilityCmsBtn', 'saveGroupBenefitsCmsBtn')
    group_js = group_js.replace('Publish Liability Changes Live', 'Publish Group Benefits Changes Live')
    group_js = group_js.replace("route('admin.liability-insurance.update')", "route('admin.group-benefits.update')")
    group_js = group_js.replace("Liability Insurance page", "Workers Compensation page")

    content = content[:js_match.start()] + liability_js + group_js + "        function saveSpecialtyCms(e)" + content[js_match.end():]
else:
    print("Could not find liability CMS JS to duplicate")

# 4. We also need to add $groupBenefitsContent to the controller's showDashboard or the view will fail.
# Wait, let's just make sure $groupBenefitsContent is passed. 
# AdminController showDashboard already exists, we need to pass the variable there.
# Let's do that via another script.

with open('resources/views/admin/dashboard.blade.php', 'w') as f:
    f.write(content)

print("Done patching dashboard.")
