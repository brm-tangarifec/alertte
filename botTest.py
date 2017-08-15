#!/usr/bin/python3.4
import sys
import telebot # Importamos las librería
import logging #Define funciones y clases para el manejo de errores
import time
from telebot import types
from telebot import util
from telebot import apihelper
from telebot import types
from pymongo import MongoClient

mongo = MongoClient()

db=mongo.callaut

reportT = db.report_tweet

reportT.insert_one({'idMensaje':768,'idTweet':'13265464','texto':'Hola'})