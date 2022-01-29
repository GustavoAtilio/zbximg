
## Version Zabbix 5.0 LTS

## Settings

```
# vim index.php
```
Sample:
```
$url_zabbix = "https://zabbix.remontti.com.br";
$user = "username";
$password = "password";
```
#### Menu >> Administration >> Media types
##### Click on Telegram >> Click on pencil (edit) and locate: 
###### "disable_web_page_preview: true," and change to "disable_web_page_preview: false,"


## Configure Zabbix Action

### ❌ Problema: <b>{HOST.NAME}</b>

```
<code>{EVENT.NAME}</code>
<b>{ITEM.NAME1}</b> <i>{ITEM.VALUE1}</i>

Tempo do evento: {EVENT.AGE} 
<a href="{HOST.IP}">{HOST.IP}</a>
<i>{EVENT.SEVERITY}</i>

<a href="https://zbximg.remontti.com.br/{ITEM.ID}-600-1600-{EVENT.ID}-1h.html">Gráfico</a>
```

### ✅ Resolvido: <b>{HOST.NAME}</b>

```
<code>{EVENT.NAME}</code>
<b>{ITEM.NAME1}</b> <i>{ITEM.VALUE1}</i>
 
Tempo do evento: {EVENT.AGE} 
<a href="{HOST.IP}">{HOST.IP}</a>
<i>{EVENT.SEVERITY}</i>

<a href="https://zbximg.remontti.com.br/{ITEM.ID}-600-1600-{EVENT.RECOVERY.ID}-1h.html">Gráfico</a>
```
## Interpreting URL 
##### Requires mod Apache Rewrite enabled
```
https://URL/{ITEM.ID}-600-1600-{EVENT.ID}-1h.html
            ↑          ↑    ↑      ↑       ↑
           item     height width  event   time
                                           ↑
                                           10m = munite(s)
                                           1h = hour(s)
                                           1d = day(s)
```
Or
```
https://URL/{ITEM.ID}-600-1600-{EVENT.ID}-1d.png
            ↑          ↑    ↑      ↑       ↑
           item     height width  event   time
                                           ↑
                                           10m = munite(s)
                                           1h = hour(s)
                                           1d = day(s)
```
