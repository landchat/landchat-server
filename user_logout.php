<?php
setcookie("lc_debug", "", time() - 3600, "/", ".lc.hywiki.xyz");
setcookie("lc_uid", "", time() - 3600, "/", ".lc.hywiki.xyz");
setcookie("lc_passw", "", time() - 3600, "/", ".lc.hywiki.xyz");
echo "<!DOCTYPE html><html><head><meta http-equiv='refresh' content='1;url=login.html'></head><body>You are logged out.<script>setTimeout(\"window.location.replace('https://app.lc.hywiki.xyz')\", 1000);</script></body></html>";