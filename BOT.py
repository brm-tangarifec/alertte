#!/usr/bin/python3.4
import sys
import telebot # Importamos las librería
import logging #Define funciones y clases para el manejo de errores
import string #Para acceder a las funciones de texto

from telebot import types
from telebot import util
from telebot import apihelper
from pymongo import MongoClient
from datetime import datetime
import time

#Se inicia la conexión a mongo
mongo = MongoClient()

#Se selecciona la base de datos
db=mongo.callaut

#Se selecciona la conexión
reportT = db.report_tweet


param_1= sys.argv[1]
#texto = '&lt;p color:&quot;style:red&quot;&gt;Rojo&lt;/p&gt; '+param_1
TOKEN = '415043230:AAElgeUG4kI1-bOmQEcF6UwyQxOvvxTwKM0'
tb = telebot.TeleBot(TOKEN) # Combinamos la declaración del Token con la función de la API
#Se agregan eventos de teclado
enojado="   "+b"\xF0\x9F\x98\xA1".decode("utf-8")+"  "
alegre="   "+b"\xF0\x9F\x98\x81".decode("utf-8")+"  "
neutral="   "+b"\xF0\x9F\x98\x92".decode("utf-8")+"  "
markup = types.InlineKeyboardMarkup(row_width=2)
rojo=types.InlineKeyboardButton(enojado,callback_data='rojo')
verde=types.InlineKeyboardButton(alegre,callback_data='verde')
neutro=types.InlineKeyboardButton(neutral,callback_data='Fastidio')
markup.row(rojo,verde,neutro)
#tb.send_message('-241066499', param_1,parse_mode='HTML') # Ejemplo tb.send_message('109556849', 'Hola mundo!')
tb.send_message('-229963093', param_1, reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
#tb.send_message('-1001129471791',"Hola", reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
#tb.send_message('-1001129471791','Hola, Respondeme', reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
##Se definen las funciones de callbakck

@tb.callback_query_handler(func=lambda call: call.data)  # Whenever the user taps the "more" button,
def alert_callback(call):
    if call.data=='rojo':
        msjAlertId=call.message.message_id
        msjAlertText=call.message.text
        tweet=msjAlertText.split(' ~|~ ')
        idTweeet=tweet[0]
        idTweetsrt=str(idTweeet)
        idTweetN=idTweetsrt.split(':')
        textTweet=tweet[1]
        reportT.insert_one({'idMensaje':msjAlertId,'idTweeet':idTweetN[1],'texto':textTweet,'tipoAlerta':'rojo','fecha': datetime.now()})
        sendTexto="Mensaje ID "+str(msjAlertId)+" Texto: "+str(textTweet)+" "+str(idTweeet)
        tb.send_message('-238213329',sendTexto)
        tb.send_message('-229963093',"el Tweet("+textTweet[:80]+"...)Se reportó el tweet como rojo")
    elif call.data=='verde':
        tb.send_message('-1001129471791',"Hola2")
    else:
        tb.send_message('-1001129471791',"Hola3")


        

if  sys.argv[2] == "S":
    tb.polling()
else:
    print ("bot")