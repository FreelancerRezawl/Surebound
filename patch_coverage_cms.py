import re

with open('resources/views/admin/dashboard.blade.php', 'r') as f:
    content = f.read()

# 1. Insert Sidebar Link
link_match = re.search(r'(<a class="sidebar-link" data-tab="specialty-cms">.*?</svg>\s*<span>Specialty Coverage CMS</span>\s*<span class="nav-badge"[^>]*>CMS</span>\s*</a>\n)', content, flags=re.DOTALL)
if link_match:
    specialty_link = link_match.group(1)
    coverage_link = specialty_link.replace('specialty-cms', 'coverage-cms')
    coverage_link = coverage_link.replace('Specialty Coverage', 'All Coverage')
    content = content[:link_match.start()] + specialty_link + coverage_link + content[link_match.end():]
else:
    print("Could not find specialty-cms link to duplicate")

# 2. Insert Tab Pane
tab_match = re.search(r'(<!-- TAB 9: SPECIALTY COVERAGE CMS EDITOR -->.*?</div>\s*</form>\s*</div>\s*)(<!-- TAB 10: CLAIMS PAGE CMS EDITOR -->)', content, flags=re.DOTALL)
if tab_match:
    specialty_tab = tab_match.group(1)
    
    coverage_tab = specialty_tab.replace('TAB 9: SPECIALTY COVERAGE CMS EDITOR', 'TAB 9B: COVERAGE SOLUTIONS CMS EDITOR')
    coverage_tab = coverage_tab.replace('tab-specialty-cms', 'tab-coverage-cms')
    coverage_tab = coverage_tab.replace('specialtyCmsForm', 'coverageCmsForm')
    coverage_tab = coverage_tab.replace('saveSpecialtyCms', 'saveCoverageCms')
    coverage_tab = coverage_tab.replace('Specialty Coverage CMS Editor', 'All Coverage Solutions CMS Editor')
    coverage_tab = coverage_tab.replace('Specialty Coverage page (/specialty-coverage)', 'Coverage page (/coverage)')
    coverage_tab = coverage_tab.replace("route('specialty-coverage')", "route('coverage')")
    coverage_tab = coverage_tab.replace('hero_specialty_', 'hero_coverage_')
    coverage_tab = coverage_tab.replace('$specialtyCoverageContent', '$coverageContent')
    coverage_tab = coverage_tab.replace('saveSpecialtyCmsBtn', 'saveCoverageCmsBtn')
    coverage_tab = coverage_tab.replace('Publish Specialty Changes Live', 'Publish Coverage Changes Live')

    content = content[:tab_match.start()] + specialty_tab + coverage_tab + tab_match.group(2) + content[tab_match.end():]
else:
    print("Could not find specialty CMS tab to duplicate")

# 3. Duplicate saveSpecialtyCms JS to create saveCoverageCms JS
js_match = re.search(r'(function saveSpecialtyCms\(e\) \{.*?\n        \}\n\n)        function saveBusinessCms\(e\)', content, flags=re.DOTALL)
if js_match:
    specialty_js = js_match.group(1)
    
    coverage_js = specialty_js.replace('saveSpecialtyCms', 'saveCoverageCms')
    coverage_js = coverage_js.replace('specialtyCmsForm', 'coverageCmsForm')
    coverage_js = coverage_js.replace('saveSpecialtyCmsBtn', 'saveCoverageCmsBtn')
    coverage_js = coverage_js.replace('Publish Specialty Changes Live', 'Publish Coverage Changes Live')
    coverage_js = coverage_js.replace("route('admin.specialty-coverage.update')", "route('admin.coverage.update')")
    coverage_js = coverage_js.replace("Specialty Coverage page", "All Coverage page")

    content = content[:js_match.start()] + specialty_js + coverage_js + "        function saveBusinessCms(e)" + content[js_match.end():]
else:
    print("Could not find specialty CMS JS to duplicate")

with open('resources/views/admin/dashboard.blade.php', 'w') as f:
    f.write(content)

print("Done patching dashboard.")
