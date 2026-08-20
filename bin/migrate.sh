#!/usr/bin/env bash
#
# Пълна миграция от стария сайт с една команда.
#
#   bash bin/migrate.sh https://uspehfilter.com/
#
# Прави три неща:
#   1. обхожда стария сайт и сваля съдържанието и изображенията
#   2. показва какво ще внесе (пробно), за да можеш да спреш навреме
#   3. внася в WordPress като Gutenberg блокове, с автоматично
#      разпознаване на тип съдържание и шаблон
#
# Повторно пускане обновява вече внесеното, вместо да го дублира.

set -euo pipefail

BASE="${1:-}"
OUT="${2:-migration}"

if [[ -z "$BASE" ]]; then
  echo "Употреба: bash bin/migrate.sh <адрес-на-стария-сайт> [директория]" >&2
  echo "Пример:   bash bin/migrate.sh https://uspehfilter.com/" >&2
  exit 1
fi

cd "$(dirname "$0")/.."
THEME="wp-content/themes/uspeh-filter"

# WP-CLI: през docker compose, ако е налично, иначе локалната команда.
if command -v wp >/dev/null 2>&1; then
  WP="wp"
elif docker compose ps >/dev/null 2>&1; then
  WP="docker compose run --rm wpcli wp"
else
  echo "Не намирам wp-cli. Инсталирай го или пусни през docker compose." >&2
  exit 1
fi

echo "──────────────────────────────────────────────"
echo " 1/3  Обхождам $BASE"
echo "──────────────────────────────────────────────"
php "$THEME/bin/migrate-fetch.php" --base="$BASE" --out="$OUT" --lang=1

echo
echo "──────────────────────────────────────────────"
echo " 2/3  Какво ще бъде внесено"
echo "──────────────────────────────────────────────"
$WP eval-file "$THEME/bin/migrate-import.php" -- --dir="$OUT" --auto --dry-run

echo
read -r -p "Да продължа ли с внасянето? [y/N] " answer
if [[ ! "$answer" =~ ^[YyДд]$ ]]; then
  echo "Прекратено. Съдържанието остава в $OUT/ — можеш да го прегледаш и да пуснеш пак."
  exit 0
fi

echo
echo "──────────────────────────────────────────────"
echo " 3/3  Внасям"
echo "──────────────────────────────────────────────"
$WP eval-file "$THEME/bin/migrate-import.php" -- --dir="$OUT" --auto

echo
echo "Готово. Следващи стъпки:"
echo "  • прегледай страниците в администрацията (типизираните автоматично са отбелязани в отчета)"
echo "  • копирай $OUT/redirects.generated.php в масива на inc/redirects.php"
echo "  • закачи менютата от Външен вид → Менюта"
