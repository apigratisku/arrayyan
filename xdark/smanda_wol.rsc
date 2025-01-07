# oct/19/2021 10:26:47 by RouterOS 6.48.3
# software id = LG06-FYBT
#
# model = RouterBOARD 3011UiAS
# serial number = B88D0A50C880
/system script
add dont-require-permissions=yes name=msg_wol_server1 owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source=\
    "/tool wol interface=ether3-to-SW-Server mac=70-85-C2-FD-AC-75"
add dont-require-permissions=yes name=msg_wol_server2 owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source=\
    "/tool wol interface=ether3-to-SW-Server mac=70-85-C2-FD-AC-75"
add dont-require-permissions=yes name=msg_wol_server3 owner=noc-mtr policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon source=\
    "/tool wol interface=ether3-to-SW-Server mac=70-85-C2-FD-AC-75"
