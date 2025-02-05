@echo off
echo Alarm at the start of the hour!
powershell -c (New-Object Media.SoundPlayer "C:\Windows\Media\Alarm01.wav").PlaySync()
