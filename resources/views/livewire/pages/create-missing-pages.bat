@echo off
setlocal enabledelayedexpansion

REM Target directory for Volt pages
set "PAGES_DIR=C:\Users\levis\Herd\Wantam\resources\views\livewire\pages"

REM List of Volt page names
set pages=about contact faq help terms privacy cart wishlist track-order about how-to-shop payment-methods money-back returns shipping cart

REM Go to directory
cd /d "%PAGES_DIR%" || (
    echo ❌ Directory not found: %PAGES_DIR%
    exit /b 1
)

REM Loop through each page and create if missing
for %%p in (%pages%) do (
    set "FILENAME=%%p.blade.php"
    if not exist "!FILENAME!" (
        echo ➕ Creating !FILENAME!...

        REM Create the file line by line using append (>>)
        echo ^<?php> "!FILENAME!"
        echo.>> "!FILENAME!"
        echo use Livewire\Volt\Component;>> "!FILENAME!"
        echo.>> "!FILENAME!"
        echo new class extends Component {>> "!FILENAME!"
        echo     // You can define properties, mount^), computed^), or actions here.>> "!FILENAME!"
        echo };>> "!FILENAME!"
        echo.>> "!FILENAME!"
        echo ^?^> >> "!FILENAME!"
        echo.>> "!FILENAME!"
        echo ^^^<div class="container py-5"^^^> >> "!FILENAME!"
        echo     ^^^<h1 class="text-2xl font-bold"^^^>%%p Page^^^</h1^^^> >> "!FILENAME!"
        echo     ^^^<p^^^>This is the %%p page built with Livewire Volt ^(anonymous class^).^^^</p^^^> >> "!FILENAME!"
        echo ^^^</div^^^> >> "!FILENAME!"
    ) else (
        echo ⚠️  Already exists: !FILENAME!
    )
)

echo.
echo ✅ All pages created successfully.
pause
