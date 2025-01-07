/system script
add name=NOC_RADIO_CEK_REALTIME owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source="#\
    Gmedia Mataram [AdhitGM]\r\
    \n:local distance;\r\
    \n:local ccqtx;\r\
    \n:local ccqrx;\r\
    \n:local signaltx;\r\
    \n:local signalrx;\r\
    \n:local ipaddr;\r\
    \n:local currentAddress [/ip address get [find interface=\"bridge1\"] addr\
    ess] \r\
    \n:set currentAddress [:pick \$currentAddress 0 [:find \$currentAddress \"\
    /\" -1]]\r\
    \n\r\
    \n:set signaltx [/interface wireless registration-table get number=0 tx-si\
    gnal-strength];\r\
    \n:set signalrx [/interface wireless registration-table get number=0 signa\
    l-strength-ch0];\r\
    \n:set ccqtx [/interface wireless registration-table get number=0 tx-ccq];\
    \r\
    \n:set ccqrx [/interface wireless registration-table get number=0 rx-ccq];\
    \r\
    \n:set distance [/interface wireless registration-table get number=0 dista\
    nce];\r\
    \n\r\
    \n/tool fetch url=\"https://www.arrayyan.web.id/xdark/noc_check.php\" mode\
    =https http-method=post  http-data=\"MODEL=REALTIME&SEKTOR=\$identity&PELA\
    NGGAN=\$comment&IP=\$currentAddress&JARAK=\$distance&SIGNALTX=\$signaltx&S\
    IGNALRX=\$signalrx&CCQTX=\$ccqtx&CCQRX=\$ccqrx\" keep-result=no;\r\
    \n"
