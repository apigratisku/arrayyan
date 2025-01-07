/system script
add name=NOC_RADIO_CEK_LOG owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source="#\
    Gmedia Mataram [AdhitGM]\r\
    \n:foreach i in=[ /interface wireless registration-table find ap=no] do={\
    \r\
    \n:local maxsignaltx 75;\r\
    \n:local maxsignalrx 75;\r\
    \n:local minccqtx 50;\r\
    \n:local minccqrx 50;\r\
    \n:local identity [/system identity get value-name=name];\r\
    \n:local ipaddr [/interface wireless registration-table get \$i value-name\
    =last-ip];\r\
    \n:local comment [/interface wireless registration-table get \$i value-nam\
    e=comment];\r\
    \n:local distance [/interface wireless registration-table get \$i value-na\
    me=distance];\r\
    \n:local ccqtx [/interface wireless registration-table get \$i value-name=\
    tx-ccq];\r\
    \n:local ccqrx [/interface wireless registration-table get \$i value-name=\
    rx-ccq];\r\
    \n:local signaltx [/interface wireless registration-table get \$i value-na\
    me=tx-signal-strength];\r\
    \n:local signalrx [/interface wireless registration-table get \$i value-na\
    me=signal-strength-ch0];\r\
    \n\r\
    \n:if ((\$ccqrx <= \$minccqrx) || (\$signaltx >= \$maxsignalrx)) do={\r\
    \n/tool fetch url=\"https://www.arrayyan.web.id/xdark/noc_check.php\" mode=https\
    \_http-method=post  http-data=\"MODEL=LOG&SEKTOR=\$identity&PELANGGAN=\$co\
    mment&IP=\$ipaddr&JARAK=\$distance&SIGNALTX=\$signaltx&SIGNALRX=\$signalrx\
    &CCQTX=\$ccqtx&CCQRX=\$ccqrx\" keep-result=no;\r\
    \n} else { \r\
    \n/tool fetch url=\"https://www.arrayyan.web.id/xdark/noc_check.php\" mode=https\
    \_http-method=post  http-data=\"MODEL=GETNORMAL&PELANGGAN=\$comment\" keep\
    -result=no; \r\
    \n}}"
