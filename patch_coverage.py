import re

with open('app/Http/Controllers/AdminController.php', 'r') as f:
    content = f.read()

# 1. Duplicate getDefaultSpecialtyCoverageContent
content_match = re.search(r'(    public static function getDefaultSpecialtyCoverageContent\(\): array\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if content_match:
    specialty_content_method = content_match.group(1)
    
    coverage_content_method = specialty_content_method.replace('getDefaultSpecialtyCoverageContent', 'getDefaultCoverageContent')
    coverage_content_method = coverage_content_method.replace('images/hero-specialty.jpg', 'images/hero-business.jpg')
    coverage_content_method = coverage_content_method.replace('SPECIALTY & NICHE COVERAGE', 'ALL COVERAGE SOLUTIONS')
    coverage_content_method = coverage_content_method.replace('Unique Protection for<br>Unique Risks', 'Comprehensive Insurance<br>For Every Need')
    coverage_content_method = coverage_content_method.replace('specialty', 'coverage')
    
    content = content[:content_match.end()] + "\n" + coverage_content_method + content[content_match.end():]
else:
    print("Could not find getDefaultSpecialtyCoverageContent")

# 2. Duplicate showSpecialtyCoverage
show_match = re.search(r'(    public function showSpecialtyCoverage\(\)\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if show_match:
    specialty_show_method = show_match.group(1)
    
    coverage_show_method = specialty_show_method.replace('showSpecialtyCoverage', 'showCoverage')
    coverage_show_method = coverage_show_method.replace("'specialty-coverage'", "'coverage'")
    coverage_show_method = coverage_show_method.replace('getDefaultSpecialtyCoverageContent', 'getDefaultCoverageContent')
    
    content = content[:show_match.end()] + "\n" + coverage_show_method + content[show_match.end():]
else:
    print("Could not find showSpecialtyCoverage")

# 3. Duplicate updateSpecialtyCoverage
update_match = re.search(r'(    public function updateSpecialtyCoverage\(Request \$request\)\n    \{.*?\n    \}\n)', content, flags=re.DOTALL)
if update_match:
    specialty_update_method = update_match.group(1)
    
    coverage_update_method = specialty_update_method.replace('updateSpecialtyCoverage', 'updateCoverage')
    coverage_update_method = coverage_update_method.replace("'specialty-coverage'", "'coverage'")
    coverage_update_method = coverage_update_method.replace('Specialty Coverage', 'All Coverage')
    coverage_update_method = coverage_update_method.replace('getDefaultSpecialtyCoverageContent', 'getDefaultCoverageContent')
    
    content = content[:update_match.end()] + "\n" + coverage_update_method + content[update_match.end():]
else:
    print("Could not find updateSpecialtyCoverage")

# 4. Add to showDashboard
dash_content_match = re.search(r'(\$specialtyCoverageContent = PageContent::getForPage\(\'specialty-coverage\', self::getDefaultSpecialtyCoverageContent\(\)\);)', content)
if dash_content_match:
    new_dash_content = dash_content_match.group(1) + "\n        $coverageContent = PageContent::getForPage('coverage', self::getDefaultCoverageContent());"
    content = content[:dash_content_match.start()] + new_dash_content + content[dash_content_match.end():]

compact_match = re.search(r'(\'specialtyCoverageContent\',)', content)
if compact_match:
    new_compact = compact_match.group(1) + "\n            'coverageContent',"
    content = content[:compact_match.start()] + new_compact + content[compact_match.end():]


with open('app/Http/Controllers/AdminController.php', 'w') as f:
    f.write(content)

print("Done patching AdminController.")
