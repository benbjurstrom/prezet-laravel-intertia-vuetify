yarn run prettier --config quality/.prettierrc.yaml --write app tests
php vendor/bin/phpmd app,tests ansi quality/rulesets.xml
php vendor/bin/phpstan analyse -c quality/phpstan.neon

# CI
# yarn run prettier --config quality/.prettierrc.yaml --check app tests
# php vendor/bin/phpmd app,tests text quality/rulesets.xml
# php vendor/bin/phpstan analyse -c quality/phpstan.neon --no-ansi --no-progress
