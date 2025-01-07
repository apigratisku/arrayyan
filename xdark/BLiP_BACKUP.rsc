/system script
add name=BLiP_BACKUP owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source="/\
    file remove [find type=script]\r\
    \n\r\
    \n:global filename ([/system identity get name])\r\
    \n:log info \"backup rsc beginning now\"\r\
    \nexport compact file=\"\$filename\"\r\
    \n:log info \"backup rsc finished\"\r\
    \n\r\
    \n/tool fetch address=10.247.10.99 port=2211 src-path=\"\$filename.rsc\" u\
    ser=blipbackup mode=ftp password=081917946641 dst-path=\"\$filename.rsc\" upl\
    oad=yes\r\
    \n\r\
    \n:log info \"Backup Uploaded Successfully\""
