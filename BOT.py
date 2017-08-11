#!/usr/bin/python3.4
import sys
import telebot # Importamos las librería

from telebot import types
from telebot import util


param_1= sys.argv[1]
#texto = '&lt;p color:&quot;style:red&quot;&gt;Rojo&lt;/p&gt; '+param_1
TOKEN = '415043230:AAElgeUG4kI1-bOmQEcF6UwyQxOvvxTwKM0'
tb = telebot.TeleBot(TOKEN) # Combinamos la declaración del Token con la función de la API
#Se agregan eventos de teclado
enojado="   "+b"\xF0\x9F\x98\xA1".decode("utf-8")+"  "
alegre="   "+b"\xF0\x9F\x98\x81".decode("utf-8")+"  "
neutral="   "+b"\xF0\x9F\x98\x92".decode("utf-8")+"  "
markup = types.InlineKeyboardMarkup(row_width=2)
rojo=types.InlineKeyboardButton(enojado,callback_data='Rojo')
verde=types.InlineKeyboardButton(alegre,callback_data='Verde')
neutro=types.InlineKeyboardButton(neutral,callback_data='Fastidio')
markup.row(rojo,verde,neutro)
#tb.send_message('-241066499', param_1,parse_mode='HTML') # Ejemplo tb.send_message('109556849', 'Hola mundo!')
tb.send_message('-241066499', param_1, reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
#tb.send_message('-241066499',"Hola", reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
#tb.send_message('-241066499','Hola, Respondeme', reply_markup=markup) # Ejemplo tb.send_message('109556849', 'Hola mundo!')
