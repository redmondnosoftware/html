#!/bin/bash
#Ejemplo de crontab
#IAmAlive SMTP 
#0 * * * * /usr/local/nagios/libexec/scripts/IAmAliveSMTP.sh $HOSTNAME redmondalarmsx@gmail.com &> /dev/null
PLATAFORM=$1
CONTACTEMAIL=$2
SUBJECT="SMTP se encuentra funcionando correctamente."

# En Colombia: /usr/bin/printf "%b" "$PLATAFORM" | /bin/mail -s "$SUBJECT" $CONTACTEMAIL -- -r alarmasredmond@co.tigo.com
# En ESV cc: /usr/bin/printf "%b" "$PLATAFORM" | /bin/mail -s "$SUBJECT" $CONTACTEMAIL -- -r alarmasredmond@sv.tigo.com
/usr/bin/printf "%b" "$PLATAFORM" | /bin/mail -s "$SUBJECT" $CONTACTEMAIL
 
exit 0