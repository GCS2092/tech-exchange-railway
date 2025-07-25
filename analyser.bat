@echo off
"C:\sonar-scanner-cli-7.0.2.4839-windows-x64\sonar-scanner-7.0.2.4839-windows-x64\bin\sonar-scanner.bat" ^
  -Dsonar.token=sqa_3a4680b9a0242d1306aa8edce239b9a2d998ab2e ^
  -Dsonar.projectKey=mon-site-cosmetique ^
  -Dsonar.sources=. ^
  -Dsonar.host.url=http://localhost:9000
pause
