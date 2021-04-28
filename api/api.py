from flask import Flask, request, jsonify, flash, redirect, url_for
from werkzeug.utils import secure_filename
#from flask_ngrok import run_with_ngrok
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

credential_path = "C:\\Users\\shabu\\Desktop\\fluttertest\\foodapi-68021c8d36da.json"
#credential_path = "/var/www/html/web/app/foodapi-68021c8d36da.json"
os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = credential_path
project_id="future-name-268108"

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

#UPLOAD_FOLDER = '/path/to/the/uploads'
ALLOWED_EXTENSIONS = {'xlsx'}

app = Flask(__name__)
app.secret_key = os.urandom(24)
#app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
#run_with_ngrok(app)
length = 32
ing = []
calories = []
carbohydrates = []
fats = []
proteins = []
cholesterols = []

def connectdb(DBname):
    password = urllib.parse.quote_plus('L1verp@@l')
    myclient = pymongo.MongoClient("mongodb://cheasel:%s@preproject-shard-00-00-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-01-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-02-i1n8s.gcp.mongodb.net:27017/test?ssl=true&replicaSet=Preproject-shard-0&authSource=admin&retryWrites=true&w=majority"%(password))
    mydb = myclient["Food"]
    return mydb[DBname]

def insert_recipe(title, serve, description, preparations, ingredients, image, reference, date, calories, carbohydrates, cholesterol, fat, protein, user, view):
    mycol = connectdb("menu")
    if(mycol.find().count() == 0):
        data = { '_id' : 1,'user' : user, "title" : title ,"serve" : serve ,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein }, "date_add" : date, "update" : date, "views" : view}
        x = mycol.insert_one(data)
    else:
        num = mycol.find({}, {'name' : 0}).sort([('_id' ,-1)]).limit(1)
        data = { '_id' : num[0]['_id'] + 1,'user' : user, "title" : title ,"serve" : serve,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein }, "date_add" : date, "update" : date, "views" : view}
        x = mycol.insert_one(data)
    return data

def trans_ingredients(ingredients):
    translatedText = []
    client = translate.TranslationServiceClient()
    #parent = client.location_path(project_id, "global")
    location = "global"
    parent = f"projects/"+project_id+"/locations/"+location
    for i in range(len(ingredients)):
        response = client.translate_text(
            parent=parent,
            contents=[ingredients[i]],
            mime_type="text/plain",
            source_language_code="th",
            target_language_code="en-US",
        )
        for translation in response.translations:
            translatedText.append(format(translation.translated_text))
    return translatedText

def get_nutrition(translatedText, serve):
    global calories
    global carbohydrates
    global cholesterols
    global fats
    global proteins
    calorie = 0
    carbohydrate = 0
    fat = 0
    protein = 0
    cholesterol = 0
    for i in range(len(translatedText)):
        if not re.findall(r'[0-9]+', translatedText[i]):
            temp = '1 ' + translatedText[i]
            data = {"yield": serve, "ingr": [temp]}
        else:
            data = {"yield": serve, "ingr": [translatedText[i]]}
        nutrition_data = json.loads(requests.post(get_nutrition_link, json=data,headers=hdr).content.decode("utf_8", "ignore"))
        if len(nutrition_data) != 1:
            calorie += get_calories(nutrition_data)['quantity']
            carbohydrate += get_carbohydrates(nutrition_data)['quantity']
            cholesterol += get_chole(nutrition_data)['quantity']
            fat += get_fat(nutrition_data)['quantity']
            protein += get_protein(nutrition_data)['quantity']
    calories = {'quantity': calorie, 'unit': 'kcal'}
    carbohydrates = {'quantity': carbohydrate, 'unit': 'g'}
    cholesterols = {'quantity': cholesterol, 'unit': 'mg'}
    fats = {'quantity': fat, 'unit': 'g'}
    proteins = {'quantity': protein, 'unit': 'g'}

def get_calories(nutrition_data):
        try:
            return {"quantity" : float(nutrition_data['totalNutrients']['ENERC_KCAL']['quantity']) ,
                    "unit" : nutrition_data['totalNutrients']['ENERC_KCAL']['unit'] ,
                    "percent" : float(nutrition_data['totalDaily']['ENERC_KCAL']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'kcal' ,
                    "percent" : 0}
    
def get_carbohydrates(nutrition_data):
        try:
            return {"quantity" : float(nutrition_data['totalNutrients']['CHOCDF']['quantity']) ,
                    "unit" : nutrition_data['totalNutrients']['CHOCDF']['unit'] ,
                    "percent" : float(nutrition_data['totalDaily']['CHOCDF']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}
        
def get_chole(nutrition_data):
        try:
            return {"quantity" : float(nutrition_data['totalNutrients']['CHOLE']['quantity']) ,
                    "unit" : nutrition_data['totalNutrients']['CHOLE']['unit'] , 
                    "percent" : float(nutrition_data['totalDaily']['CHOLE']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'mg' ,
                    "percent" : 0}

def get_fat(nutrition_data):
        try:
            return {"quantity" : float(nutrition_data['totalNutrients']['FAT']['quantity']) ,
                    "unit" : nutrition_data['totalNutrients']['FAT']['unit'] , 
                    "percent" : float(nutrition_data['totalDaily']['FAT']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}
        
def get_protein(nutrition_data):
        try:
            return {"quantity" : float(nutrition_data['totalNutrients']['PROCNT']['quantity']) ,
                    "unit" : nutrition_data['totalNutrients']['PROCNT']['unit'] ,
                    "percent" : float(nutrition_data['totalDaily']['PROCNT']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}

def add_user(username, email, password, name, surname, food_allergy, age, gender, weight, height, admin, date, image ):
    mycol = connectdb('user')
    if(mycol.find().count() == 0):
        data = { '_id' : 1, 
                'username' : username, 
                'email' : email, 
                'password' : password, 
                'name' : name, 
                'surname' : surname, 
                'food_allergy' : food_allergy, 
                'age' : age, 
                'weight' : weight, 
                'height' : height,
                'admin' : admin,
                'update' : date,
                'image' : image,
                'gender' : gender
                }
    else:
        num = mycol.find({}, {'name' : 0}).sort([('_id' ,-1)]).limit(1)
        data = { '_id' : num[0]['_id'] + 1,
                'username' : username, 
                'email' : email, 
                'password' : password, 
                'name' : name, 
                'surname' : surname, 
                'food_allergy' : food_allergy, 
                'age' : age, 
                'weight' : weight, 
                'height' : height,
                'admin' : admin,
                'update' : date,
                'image' : image,
                'gender' : gender
                }
    x = mycol.insert_one(data)

def add_api_key(username):
    mycol = connectdb('user')
    id = (mycol.find({ "username" : username }))[0]['_id']
    key = hexlify(os.urandom(length)).decode()
    date = datetime.datetime.now()
    data = { '_id' : id,
            'api_key' : key,
            'date' : date 
            }
    mycol = connectdb('api')
    x = mycol.insert_one(data)


def allowed_file(filename):
    return '.' in filename and \
           filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

def encrypt_password(password):
    return pbkdf2_sha256.hash(password)

def check_encrypted_password(password, hashed):
    return pbkdf2_sha256.verify(password,hashed)

@app.route('/api/user/sign-up', methods=['POST'])
def sign_up():
    if 'username' and 'password' and 'email' and 'admin' in request.json:
        mycol = connectdb('user')
        username = request.json['username']
        email = request.json['email']
        if mycol.find({ "username" : username }).count() != 0 or mycol.find({ "email" : email }).count() != 0 :
            return 'Error: Username or Email address already exist.'
        password = encrypt_password(request.json['password']) 
        '''if request.json['name']!=None or 'name' in request.json: 
            name = request.json['name']
        else:'''
        name = ''
        '''if request.json['surname']!=None or 'surname' in request.json:
            surname = request.json['surname']
        else:'''
        surname = ''
        #food_allergy = request.json['food_allergy']
        food_allergy = []
        '''if request.json['age']!=None or 'age' in request.json:
            age = request.json['age']
        else:'''
        age = ''
        '''if request.json['gender']!=None or 'gender' in request.json:
            gender = request.json['gender']
        else:'''
        gender = ''
        '''if request.json['weight']!=None or 'weight' in request.json:
            weight = request.json['weight']
        else:'''
        weight = ''
        '''if request.json['height']!=None or 'height' in request.json:
            height = request.json['height']
        else:'''
        height = ''
        '''if request.json['image']!=None or 'image' in request.json:
            image = request.json['image']
        else:'''
        image = ''
        date = datetime.datetime.now()
        if request.json['admin'] == 'User':
            admin = 'False'
        else:
            admin = 'True'
        add_user(username, email, password, name, surname, food_allergy, age, gender, weight, height, admin, date, image )
        add_api_key(username)
        data = mycol.find({ "email" : email })
        return dumps(data)
    else:
        return 'Error: Information not complete. Please fill all Information.'

@app.route('/api/user/signupcheck', methods=['get'])
def signup_check():
    if 'username' in request.args:
        mycol = connectdb('user')
        username = request.args['username']
        data = mycol.find( { "username" : username })
        if data.count() >= 1:
            return '1'
        else:
            return '0'
    elif 'email' in request.args:
        mycol = connectdb('user')
        email = request.args['email']
        data = mycol.find( { "email" : email })
        if data.count() >= 1:
            return '1'
        else:
            return '0'
    else:
        return 'Error: Information not complete. Please fill all Information.'

@app.route('/api/user/sign-in', methods=['POST'])
def sign_in():
    if 'password' and 'email' in request.json:
        mycol = connectdb('user')
        email = request.json['email']
        if mycol.find({ "email" : email }).count() == 0 :
            return 'Error: wrong Email address.'
        password = mycol.find({ "email" : email })[0]['password']
        if check_encrypted_password(request.json['password'],password) is True:
            data = mycol.find({ "email" : email })
            return dumps(data)
        else:
            return 'Error: wrong password.'
    else:
        return 'Error: Information not complete. Please fill all Information.'

@app.route('/api/user/all-user', methods=['GET'])
def all_user():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() == 0:
            return 'Error: Wrong username.'
        else:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            apicol = connectdb('api')
            api_key = apicol.find({"_id": _id})[0]['api_key']
            if 'api_key' in request.args and request.args['api_key'] != api_key:
                return 'Error: Wrong api-key'
            admin = mycol.find({"_id": _id})[0]['admin']
            if admin != 'True':
                return 'Error: Not an Admin account.'
            else:
                data = mycol.find()
                return dumps(data, ensure_ascii=False)

@app.route('/api/user/user-id', methods=['GET'])
def get_user_from_id():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif 'id' not in request.args:
        return 'Error: No id. Please enter id'
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() == 0:
            return 'Error: Wrong username.'
        else:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            apicol = connectdb('api')
            api_key = apicol.find({"_id": _id})[0]['api_key']
            if 'api_key' in request.args and request.args['api_key'] != api_key:
                return 'Error: Wrong api-key'
            data = mycol.find({'_id': int(request.args['id'])})
            return dumps(data, ensure_ascii=False)

@app.route('/api/user/update', methods=['POST'])
def update_user():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif not request.json or not 'id' in request.json:
        return 'Error: No id. Please enter id'
    else:
        mycol = connectdb('user')
        if mycol.find({"_id": int(request.json['id'])}).count() == 0:
            return 'Error: Wrong account.'
        else:
            _id = request.json['id']
            name = request.json['name']
            surname = request.json['surname']
            email = request.json['email']
            age = request.json['age']
            gender = request.json['gender']
            image = request.json['image']
            height = request.json['height']
            weight = request.json['weight']
            foodallergens = request.json['foodallergens']
            date = datetime.datetime.now()

            if(image == ''):
                try:
                    mycol.update_one({ '_id': int(_id) }, { '$set': { 'name': name, 'surname': surname, 'email': email, 'age': age, 'gender': gender, 'height': height, 'weight': weight, 'food_allergy': foodallergens, 'update': date } })
                    return 'true'
                except:
                    return 'false'
            else:
                try:
                    mycol.update_one({ '_id': int(_id) }, { '$set': { 'name': name, 'surname': surname, 'email': email, 'age': age, 'gender': gender, 'image': image, 'height': height, 'weight': weight, 'food_allergy': foodallergens, 'update': date } })
                    return 'true'
                except:
                    return 'false'

@app.route('/api/user/delete', methods=["DELETE"])
def delete_user():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() != 0:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            admin = mycol.find({"username": request.args['username']})[0]['admin']
            mycol = connectdb('api')
            api_key = mycol.find({"_id": _id})[0]['api_key']
        else:
            return 'Error: Wrong username.'
        
        if admin != 'True':
            return 'Error: Only admin can delete user.'
        else:
            if 'api_key' not in request.args:
                return 'Error: No api-key. Please enter api-key. '
            elif 'api_key' in request.args and request.args['api_key'] != api_key:
                return 'Error: Wrong api-key'
            elif 'id' not in request.args:
                return 'Error: No id. Please enter id. '
            else:
                myuser = connectdb('user')
                myapi = connectdb('api')
                id = request.args['id']
                try:
                    myuser.delete_one({'_id': int(id)})
                    myapi.delete_one({'_id': int(id)})
                    return 'delete success'
                except:
                    return 'delete fail'

@app.route('/api/user/search', methods=['GET'])
def search_user():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key.'
    elif not request.args or not 'name' in request.args:
        return 'Error: No name. Please enter name'
    else:
        mycol = connectdb('user')
        name = request.args['name']
        #data = mycol.find( { "email" : { '$regex' : name} } and  { "username" : { '$regex' : name} } )
        data = mycol.find({ "$or" : [ { "email" : { '$regex' : name } } , { "username" : { '$regex' : name } } ] })
        return dumps(data,ensure_ascii=False)

@app.route('/api/menu-detail/autocomplete', methods=['GET'])
def autocomplete():
    menucol = connectdb('menu')
    if 'name' in request.args :
        name = request.args['name']
        menu = menucol.aggregate([{ "$search" : { "autocomplete" : { "query" : name , "path" : "title", "fuzzy": { "maxEdits": 2} }}}, { "$limit": 10 }, { "$project": { "_id": 0, "title": 1}}])
    else:
        return 'Error: No name. Please enter name. ' 

    return dumps(menu,ensure_ascii=False)

@app.route('/api/menu-detail/user-id', methods=['GET'])
def get_menu_from_user():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    else:
        mycol = connectdb('user')
        if mycol.find({"username": request.args['username']}).count() != 0:
            _id = mycol.find({"username": request.args['username']})[0]['_id']
            apicol = connectdb('api')
            api_key = apicol.find({"_id": _id})[0]['api_key']
        else:
            return 'Error: Wrong username.'

    if 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif 'api_key' in request.args and request.args['api_key'] != api_key:
        return 'Error: Wrong api-key'
    else:
        menucol = connectdb('menu')
        if 'limit' in request.args and 'skip' in request.args:
            skip = int(request.args['skip'])
            limit = int(request.args['limit'])
            menu = menucol.find({ "user" : request.args['id'] }).sort([('date_add' , -1)]).limit(limit).skip(skip)
        else:
            menu = menucol.find({ "user" : request.args['id'] }) .sort([('date_add', -1)])
        return dumps(menu,ensure_ascii=False)

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
                menu = menucol.find({ "ingredients.name" : { '$regex' : name} } or  {"title" : { "$regex" : name } } ).sort([('_id' , -1)]).limit(limit).skip(skip)
            else:
                menu = menucol.find({ "ingredients.name" : { '$regex' : name} } or  {"title" : { "$regex" : name } } ).sort([('_id' , -1)])
            return dumps(menu,ensure_ascii=False)
        else:
            if 'limit' in request.args and 'skip' in request.args:
                skip = int(request.args['skip'])
                limit = int(request.args['limit'])
                menu = menucol.find().sort([('_id' , -1)]).limit(limit).skip(skip)
            else:
                menu = menucol.find()
            return dumps(menu,ensure_ascii=False)      

@app.route('/api/menu-detail/ingre-name', methods=['POST'])
def post_menu_from_ingredient():
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
        if not request.json or not 'name' in request.json:
            return 'Error: No name field provieded. Please specify a name.'
        else:
            name = request.json['name']
        menucol = connectdb('menu')
        menu = menucol.find({ "ingredients.name" : { '$in' : name } })
        return dumps(menu,ensure_ascii=False)

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
            if request.json['name'] != [] and request.json['name'] != [''] :
                name = request.json['name']
                for i in range(len(name)):
                    name[i] = re.compile('.*'+name[i]+'.*')
            else:
                name = ['']
        else:
            name = ['']
        if 'exname' in request.json :
            if request.json['exname'] != [] and request.json['exname'] != [''] :
                exname = request.json['exname']
                for i in range(len(exname)):
                    exname[i] = re.compile('.*'+exname[i]+'.*')
            else:
                exname = ['']
        else:
            exname = ['']
        
        if 'limit' in request.args or 'skip' in request.args :
            if 'skip' in request.args:
                skip = int(request.args['skip'])
            else:
                skip = 0
            if 'limit' in request.args:
                limit = int(request.args['limit'])
            else:
                limit = 0

            if name == [''] and exname == [''] :
                menu = menucol.find( { "$and" : [ { "title" : { "$regex" : title } } , {"nutrition.calories.quantity" : { "$gte" : mincal, "$lt" : maxcal } } , { "nutrition.cholesterol.quantity" : { "$gte" : minchol, "$lt" : maxchol } } , { "nutrition.carbohydrates.quantity" : { "$gte" : mincarb, "$lt" : maxcarb } } , { "nutrition.fat.quantity" : { "$gte" : minfat, "$lt" : maxfat } } , { "nutrition.protein.quantity" : { "$gte" : minprotein, "$lt" : maxprotein } } ] } ).sort([('_id' , -1)]).limit(limit).skip(skip)
            else :
                menu = menucol.find( { "$and" : [ { "title" : { "$regex" : title } } , { "ingredients.name" : { '$in' : name } } , { "ingredients.name" : { "$not" : { "$in" : exname } } } , { "nutrition.calories.quantity" : { "$gte" : mincal, "$lt" : maxcal } } , { "nutrition.cholesterol.quantity" : { "$gte" : minchol, "$lt" : maxchol } }  , { "nutrition.carbohydrates.quantity" : { "$gte" : mincarb, "$lt" : maxcarb } } , { "nutrition.fat.quantity" : { "$gte" : minfat, "$lt" : maxfat } } , { "nutrition.protein.quantity" : { "$gte" : minprotein, "$lt" : maxprotein } } ] } ).sort([('_id' , -1)]).limit(limit).skip(skip)
        else:
            if name == [''] and exname == [''] :
                menu = menucol.find( { "$and" : [ { "title" : { "$regex" : title } } , {"nutrition.calories.quantity" : { "$gte" : mincal, "$lt" : maxcal } } , { "nutrition.cholesterol.quantity" : { "$gte" : minchol, "$lt" : maxchol } } , { "nutrition.carbohydrates.quantity" : { "$gte" : mincarb, "$lt" : maxcarb } } , { "nutrition.fat.quantity" : { "$gte" : minfat, "$lt" : maxfat } } , { "nutrition.protein.quantity" : { "$gte" : minprotein, "$lt" : maxprotein } } ] } ).sort([('_id' , -1)])
            else :
                menu = menucol.find( { "$and" : [ { "title" : { "$regex" : title } } , { "ingredients.name" : { '$in' : name } } , { "ingredients.name" : { "$not" : { "$in" : exname } } } , { "nutrition.calories.quantity" : { "$gte" : mincal, "$lt" : maxcal } } , { "nutrition.cholesterol.quantity" : { "$gte" : minchol, "$lt" : maxchol } }  , { "nutrition.carbohydrates.quantity" : { "$gte" : mincarb, "$lt" : maxcarb } } , { "nutrition.fat.quantity" : { "$gte" : minfat, "$lt" : maxfat } } , { "nutrition.protein.quantity" : { "$gte" : minprotein, "$lt" : maxprotein } } ] } ).sort([('_id' , -1)])
        
        return dumps(menu,ensure_ascii=False)

@app.route('/api/menu-detail/total-search-ingre', methods=['GET'])
def get_total_by_ingre():
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
        total = menucol.find({ "ingredients.name" : { '$regex' : name } } or  {"title" : { "$regex" : name } }).count()
        return str(total)

'''@app.route('/api/menu-detail/total-advance-search', methods=['POST'])
def get_total_advancesearch():
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
        if 'name' in request.json:
            name = request.json['name']
            mincal = int(request.json['mincal'])
            maxcal = int(request.json['maxcal'])
        else:
            return 'Error: No name field provieded. Please specify a name.'
        menucol = connectdb('menu')
        total = menu = menucol.find( { "$and" : [ { "ingredients.name" : { '$in' : name} } , { "nutrition.calories.quantity" : { "$gte" : mincal, "$lt" : maxcal } } ] } ).count()
        return str(total)'''

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

@app.route('/api/menu-detail/menu-id', methods=['GET'])
def get_menu_from_id():
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
        if 'id' in request.args:
            menu_id = int(request.args['id'])
        else:
            return 'Error: No id field provieded. Please specify a id.'
        menucol = connectdb('menu')
        menu = menucol.find({ "_id" : menu_id } )
        return dumps(menu,ensure_ascii=False)

@app.route('/api/menu-detail/view', methods=['GET'])
def get_menu_from_view():
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
        menu = menucol.find().sort([ ('views' , -1) ]).limit(5)
        return dumps(menu,ensure_ascii=False)

@app.route('/api/menu-detail/total-menu', methods=['GET'])
def get_total_menu():
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
        total = menucol.find().count()
        return str(total)

@app.route('/api/menu-detail/limit-menu', methods=['GET'])
def get_limit_menu():
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
        if 'skip' in request.args:
            skip = int(request.args['skip'])
        else:
            return 'Error: No skip field provieded. Please specify a skip.'
        menucol = connectdb('menu')
        if 'limit' in request.args and 'skip' in request.args:
            skip = int(request.args['skip'])
            limit = int(request.args['limit'])
            menu = menucol.find().sort([('_id' , -1)]).limit(limit).skip(skip)
        else:
            menu = menucol.find().sort([('_id' , -1)])  
        return dumps(menu,ensure_ascii=False)

@app.route('/api/add-excel', methods=['POST'])
def add_excel_menu():
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
        if request.method == 'POST':
            if 'file' not in request.files:
                return 'no file'
            file = request.files['file']
            if file.filename == '':
                return 'no selected file'
            if file and allowed_file(file.filename):
                menu = {
                    'title' : [],
                    'serve' : [],
                    'preparations' : [],
                    'ingredients' : [],
                    'image' : [],
                    'reference' : []
                }
                recipe = pd.read_excel(file, dtype = 'str')
                #recipe = pd.concat(pd.read_excel(file, sheet_name=None), ignore_index=True)
                for i in range(len(recipe)):
                    menu['title'].append(recipe['title'][i]) 
                    menu['serve'].append(recipe['serve'][i]) 
                    menu['preparations'].append(recipe['preparations'][i].split(',')) 
                    menu['ingredients'].append(recipe['ingredients'][i].split(',')) 
                    #menu['image'].append(recipe['image'][i]) 
                    menu['reference'].append(recipe['reference'][i]) 
        return menu
        '''data = {}
        for tmp in range(len(recipe)):
            ing.clear()
            for j in menu['ingredients'][tmp]:
                temp = len(j.split()) - 1
                name = ''
                if not re.findall(r'[0-9]+', j):
                    name = j.strip()
                    value = ''
                    unit = ''
                    ing.append({'name' : name, 'value' : value, 'unit' : unit})
                else:
                    for k in range(len(j.split())):
                        if(j.split()[temp].isnumeric() is False ):
                            unit = j.split()[temp]
                        else:
                            value = j.split()[temp]
                            while(temp > 0):
                                temp -= 1
                                name = j.split()[temp] + name
                            ing.append({'name' : name.strip(), 'value' : value, 'unit' : unit})
                            break
                        temp -= 1

            global calories
            global carbohydrates
            global cholesterols
            global fats
            global proteins
            calories.clear()
            carbohydrates.clear()
            cholesterols.clear()
            fats.clear()
            proteins.clear()

            trans = trans_ingredients(menu['ingredients'][tmp])
            
            get_nutrition(trans, menu['serve'][tmp])
            data[tmp] = insert_recipe(menu['title'][tmp], menu['serve'][tmp], menu['preparations'][tmp], ing, menu['image'][tmp], menu['reference'][tmp], calories, carbohydrates, cholesterols, fats, proteins)'''
        
        #return pd.Series(recipe.index).fillna(method='ffill')

@app.route('/api/add-recipe', methods=['POST'])
def add_recipe():
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
        if not request.json or not 'title' and 'serve' and 'ingredients' and 'preparations' and 'description' and 'image' and 'reference' and 'user' in request.json:
            return 'Error: Missing Informations. Please specify all Informations.'
        else:
            title = request.json['title']
            serve = request.json['serve']
            description = request.json['description']
            ingredients = request.json['ingredients']
            preparations = request.json['preparations']
            image = request.json['image']
            reference = ''
            date = datetime.datetime.now()
            user = request.json['user']
            view = 0
        ing.clear()
        for i in ingredients:
            ingdata = i['name']+' '+str(i['value'])+' '+i['unit']
            ing.append(ingdata)
        
        '''for i in ingredients:
            temp = len(i.split()) - 1
            name = ''
            if not re.findall(r'[0-9]+', i):
                name = i.strip()
                value = ''
                unit = ''
                ing.append({'name' : name, 'value' : value, 'unit' : unit})
            else:
                for j in range(len(i.split())):
                    if(i.split()[temp].isnumeric() is False ):
                        unit = i.split()[temp]
                    else:
                        value = i.split()[temp]
                        while(temp > 0):
                            temp -= 1
                            name = i.split()[temp] + name
                        ing.append({'name' : name.strip(), 'value' : value, 'unit' : unit})
                        break
                    temp -= 1'''

        global calories
        global carbohydrates
        global cholesterols
        global fats
        global proteins

        trans = trans_ingredients(ing)
        get_nutrition(trans, serve)
        return insert_recipe(title, serve, description, preparations, ingredients, image, reference, date, calories, carbohydrates, cholesterols, fats, proteins, user, view)

@app.route('/api/menu/update', methods=['POST'])
def update_menu():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    elif not request.json or not 'userid' in request.json:
        return 'Error: No id. Please enter id'
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
            if not request.json or not 'foodid' and 'title' and 'serve' and 'ingredients' and 'preparations' and 'description' and 'image' and 'userid' in request.json:
                return 'Error: Missing Informations. Please specify all Informations.'
            else:
                foodid = request.json['foodid']
                title = request.json['title']
                serve = request.json['serve']
                description = request.json['description']
                ingredients = request.json['ingredients']
                preparations = request.json['preparations']
                image = request.json['image']
                reference = ''
                date = datetime.datetime.now()
                user = request.json['userid']
        ing.clear()
        for i in ingredients:
            #return i
            ingdata = i['name']+' '+str(i['value'])+' '+i['unit']
            ing.append(ingdata)
        
        global calories
        global carbohydrates
        global cholesterols
        global fats
        global proteins

        trans = trans_ingredients(ing)
        get_nutrition(trans, serve)

        mycol = connectdb("menu")

        if(image == '' or image == None):
            try:
                mycol.update_one({ '_id' : int(foodid)}, { '$set': { 'user' : user, "title" : title ,"serve" : serve ,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterols ,"fat" : fats ,"protein" : proteins },"update" : date }})
                return 'true'
            except:
                return 'false'
        else:
            try:
                data = mycol.update_one({ '_id' : int(foodid)}, { '$set': { 'user' : user, "title" : title ,"serve" : serve ,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterols ,"fat" : fats ,"protein" : proteins },"update" : date }})
                return 'true'
            except:
                return 'false'

@app.route('/api/menu/delete', methods=['DELETE'])
def delete_menu():
    if 'username' not in request.args:
        return 'Error: No username. Please enter username.'
    elif 'api_key' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
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
            if 'id' not in request.args:
                return 'Error: Missing Informations. Please specify all Informations.'
            else:
                foodid = request.args['id']
                myfood = connectdb('menu')
                try:
                    myfood.delete_one({'_id': int(foodid)})
                    return 'delete success'
                except:
                    return 'delete fail'

@app.route('/api/recipe/view', methods=['GET'])
def view_update():
    if 'foodid' not in request.args:
        return 'Error: No api-key. Please enter api-key. '
    else:
        foodid = request.args['foodid']
        menucol = connectdb('menu')
        menucol.update_one({ '_id' : int(foodid)}, { '$inc': { 'views' : 1 }})
        return 'true'

@app.route('/api/imgpath', methods=['GET'])
def path_update():
    menucol = connectdb('menu')
    data = menucol.find()
    for i in data:
        menucol.update_one({ '_id' : i["_id"]}, { '$set': { 'image': 'food_image/food_img_'+str(i["_id"])+'.jpg'}})
    return 'true'

def get_token():
    conn = http.client.HTTPSConnection("api.sirv.com")
    payload = "{\"clientId\":\"SxAu8RlwWAnK287F595Q09Bt1kc\",\"clientSecret\":\"/wt6zayuTLFYeiei8mxY/lOqkKZ/lVTuS4gXMjJvikWJSXF8M7NL21gGykUcpV1bHbAE7KF4f5MHTtRZdetk8A==\"}"
    headers = {
        'content-type': "application/json"
    }
    conn.request("POST", "/v2/token", payload, headers)
    res = conn.getresponse()
    data = res.read()
    return json.loads(data.decode("utf-8"))


@app.route('/api/upload', methods=['GET'])
def upload_img():
    import io
    menucol = connectdb('menu')
    data = menucol.find().skip(1109)
    j = 1;
    for i in data:
        conn = http.client.HTTPSConnection("api.sirv.com")
        payload = Image.open(requests.get(i['image'], stream=True).raw)
        img_byte_arr = io.BytesIO()
        rgb_im = payload.convert('RGB')
        rgb_im.save(img_byte_arr, format='JPEG')
        img_byte_arr = img_byte_arr.getvalue()
        if( j % 100 == 0 or j == 1 ):
            token = get_token()
        headers = {
            'content-type': "application/json",
            'authorization': "Bearer "+token['token']
        }
        conn.request("POST", "/v2/files/upload?filename=%2Ffood_image%2Ffood_img_"+str(i['_id'])+".jpg", img_byte_arr, headers)
        res = conn.getresponse()
        data = res.read()
        j += 1
    return 'finish'

if __name__ == '__main__':
    #mycol = connectdb("menu")
    #mycol.update_many({"views": {"$exists": False}}, {"$set": {"views": 0}})
    app.debug = True
    app.run()  
    