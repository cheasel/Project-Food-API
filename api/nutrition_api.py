from flask import Flask, request, jsonify, flash, redirect, url_for
from werkzeug.utils import secure_filename
import urllib.parse
import requests
import pymongo
import json
import re
import random
from bson.json_util import dumps
from binascii import hexlify
import datetime
import os
from google.cloud import translate
import pandas as pd
from passlib.hash import pbkdf2_sha256
import http.client
from PIL import Image

#credential_path = "C:\\Users\\shabu\\Desktop\\fluttertest\\foodapi-68021c8d36da.json"
credential_path = "/var/www/html/web/app/foodapi-68021c8d36da.json"
os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = credential_path
project_id = "future-name-268108"

get_nutrition_link = "https://api.edamam.com/api/nutrition-details?app_id=20334a52&app_key=19c996cb1f61d2d9f2a71efbbc87c97d"

user_agent_list = ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36',
                   'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36',
                   'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/70.0',
                   'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36 OPR/64.0.3417.73',
                   'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36 OPR/64.0.3417.73',
                   'Mozilla/5.0 (Windows NT 10.0; Trident/7.0; rv:11.0) like Gecko'
                   ]
user_agent = random.choice(user_agent_list)
hdr = {'accept': 'test/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
       'referer': 'http://www.google.com/',
       'user-agent': user_agent}

ALLOWED_EXTENSIONS = {'xlsx'}

app = Flask(__name__)
app.secret_key = os.urandom(24)
length = 32
ing = []
calories = []
carbohydrates = []
fats = []
proteins = []
cholesterols = []


def connectdb(DBname):
    password = urllib.parse.quote_plus('L1verp@@l')
    myclient = pymongo.MongoClient(
        "mongodb://cheasel:%s@preproject-shard-00-00-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-01-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-02-i1n8s.gcp.mongodb.net:27017/test?ssl=true&replicaSet=Preproject-shard-0&authSource=admin&retryWrites=true&w=majority" % (password))
    mydb = myclient["Food"]
    return mydb[DBname]


@app.route('/api/menu-detail/ingre-name', methods=['GET'])
def get_menu_from_ingredient():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() != 0:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            mycol = connectdb('api')
            api_key = mycol.find({"_id": _id})[0]['api_key']
        else:
            return 'Error: Wrong username.'

    if 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif 'api_key' in request.args and request.args['api_key'] != api_key:
        return 'Error: Wrong api-key'
    else:
        if 'name' in request.args:
            name = str(request.args['name'])
            menucol = connectdb('menu')
            if 'limit' in request.args and 'skip' in request.args:
                skip = int(request.args['skip'])
                limit = int(request.args['limit'])
                menu = menucol.find({"ingredients.name": {'$regex': name}} or {
                                    "title": {"$regex": name}}).sort([('_id', -1)]).limit(limit).skip(skip)
            else:
                menu = menucol.find({"ingredients.name": {'$regex': name}} or {
                                    "title": {"$regex": name}}).sort([('_id', -1)])
            return dumps(menu, ensure_ascii=False)
        else:
            if 'limit' in request.args and 'skip' in request.args:
                skip = int(request.args['skip'])
                limit = int(request.args['limit'])
                menu = menucol.find().sort(
                    [('_id', -1)]).limit(limit).skip(skip)
            else:
                menu = menucol.find()
            return dumps(menu, ensure_ascii=False)


@app.route('/api/menu-detail/advance-search', methods=['POST'])
def get_menu_advance_search():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() != 0:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            mycol = connectdb('api')
            api_key = mycol.find({"_id": _id})[0]['api_key']
        else:
            return 'Error: Wrong username.'

    if 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif 'api_key' in request.args and request.args['api_key'] != api_key:
        return 'Error: Wrong api-key'
    else:
        menucol = connectdb('menu')
        if 'mincal' in request.json:
            mincal = int(request.json['mincal'])
        else:
            mincal = 0
        if 'maxcal' in request.json:
            maxcal = int(request.json['maxcal'])
        else:
            maxcal = 9999
        if 'minchol' in request.json:
            minchol = int(request.json['minchol'])
        else:
            minchol = 0
        if 'maxchol' in request.json:
            maxchol = int(request.json['maxchol'])
        else:
            maxchol = 9999
        if 'mincarb' in request.json:
            mincarb = int(request.json['mincarb'])
        else:
            mincarb = 0
        if 'maxcarb' in request.json:
            maxcarb = int(request.json['maxcarb'])
        else:
            maxcarb = 9999
        if 'minfat' in request.json:
            minfat = int(request.json['minfat'])
        else:
            minfat = 0
        if 'maxfat' in request.json:
            maxfat = int(request.json['maxfat'])
        else:
            maxfat = 9999
        if 'minprotein' in request.json:
            minprotein = int(request.json['minprotein'])
        else:
            minprotein = 0
        if 'maxprotein' in request.json:
            maxprotein = int(request.json['maxprotein'])
        else:
            maxprotein = 9999

        if 'title' in request.json:
            title = str(request.json['title'])
        else:
            return 'Error: No title field provieded. Please specify a title.'

        if 'name' in request.json:
            if request.json['name'] != [] and request.json['name'] != ['']:
                name = request.json['name']
                for i in range(len(name)):
                    name[i] = re.compile('.*'+name[i]+'.*')
            else:
                name = ['']
        else:
            name = ['']
        if 'exname' in request.json:
            if request.json['exname'] != [] and request.json['exname'] != ['']:
                exname = request.json['exname']
                for i in range(len(exname)):
                    exname[i] = re.compile('.*'+exname[i]+'.*')
            else:
                exname = ['']
        else:
            exname = ['']

        if 'limit' in request.args or 'skip' in request.args:
            if 'skip' in request.args:
                skip = int(request.args['skip'])
            else:
                skip = 0
            if 'limit' in request.args:
                limit = int(request.args['limit'])
            else:
                limit = 0

            if name == [''] and exname == ['']:
                menu = menucol.find({"$and": [{"title": {"$regex": title}}, {"nutrition.calories.quantity": {"$gte": mincal, "$lt": maxcal}}, {"nutrition.cholesterol.quantity": {"$gte": minchol, "$lt": maxchol}}, {"nutrition.carbohydrates.quantity": {
                                    "$gte": mincarb, "$lt": maxcarb}}, {"nutrition.fat.quantity": {"$gte": minfat, "$lt": maxfat}}, {"nutrition.protein.quantity": {"$gte": minprotein, "$lt": maxprotein}}]}).sort([('_id', -1)]).limit(limit).skip(skip)
            else:
                menu = menucol.find({"$and": [{"title": {"$regex": title}}, {"ingredients.name": {'$in': name}}, {"ingredients.name": {"$not": {"$in": exname}}}, {"nutrition.calories.quantity": {"$gte": mincal, "$lt": maxcal}}, {"nutrition.cholesterol.quantity": {"$gte": minchol, "$lt": maxchol}}, {
                                    "nutrition.carbohydrates.quantity": {"$gte": mincarb, "$lt": maxcarb}}, {"nutrition.fat.quantity": {"$gte": minfat, "$lt": maxfat}}, {"nutrition.protein.quantity": {"$gte": minprotein, "$lt": maxprotein}}]}).sort([('_id', -1)]).limit(limit).skip(skip)
        else:
            if name == [''] and exname == ['']:
                menu = menucol.find({"$and": [{"title": {"$regex": title}}, {"nutrition.calories.quantity": {"$gte": mincal, "$lt": maxcal}}, {"nutrition.cholesterol.quantity": {"$gte": minchol, "$lt": maxchol}}, {
                                    "nutrition.carbohydrates.quantity": {"$gte": mincarb, "$lt": maxcarb}}, {"nutrition.fat.quantity": {"$gte": minfat, "$lt": maxfat}}, {"nutrition.protein.quantity": {"$gte": minprotein, "$lt": maxprotein}}]}).sort([('_id', -1)])
            else:
                menu = menucol.find({"$and": [{"title": {"$regex": title}}, {"ingredients.name": {'$in': name}}, {"ingredients.name": {"$not": {"$in": exname}}}, {"nutrition.calories.quantity": {"$gte": mincal, "$lt": maxcal}}, {"nutrition.cholesterol.quantity": {
                                    "$gte": minchol, "$lt": maxchol}}, {"nutrition.carbohydrates.quantity": {"$gte": mincarb, "$lt": maxcarb}}, {"nutrition.fat.quantity": {"$gte": minfat, "$lt": maxfat}}, {"nutrition.protein.quantity": {"$gte": minprotein, "$lt": maxprotein}}]}).sort([('_id', -1)])

        return dumps(menu, ensure_ascii=False)

@app.route('/api/menu-detail/menu-name', methods=['GET'])
def get_menu_from_name():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() != 0:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            mycol = connectdb('api')
            api_key = mycol.find({"_id": _id})[0]['api_key']
        else:
            return 'Error: Wrong username.'

    if 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif 'api_key' in request.args and request.args['api_key'] != api_key:
        return 'Error: Wrong api-key'
    else:
        if 'name' in request.args:
            name = str(request.args['name'])
        else:
            return 'Error: No name field provieded. Please specify a name.'
        menucol = connectdb('menu')
        menu = menucol.find({ "title" : { "$regex" : name } } )
        return dumps(menu,ensure_ascii=False)