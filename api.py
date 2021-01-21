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

#credential_path = "C:\\Users\\shabu\Desktop\\fluttertest\\foodapi-68021c8d36da.json"
#os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = credential_path
#project_id="future-name-268108"

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

def insert_receipe(title, serve, description, preparations, ingredients, image, reference, date, calories, carbohydrates, cholesterol, fat, protein, user):
    mycol = connectdb("menu")
    if(mycol.find().count() == 0):
        data = { '_id' : 1,'user' : user, "title" : title ,"serve" : serve ,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein }, "date_add" : date, "update" : '' }
        x = mycol.insert_one(data)
    else:
        num = mycol.find({}, {'name' : 0}).sort([('_id' ,-1)]).limit(1)
        data = { '_id' : num[0]['_id'] + 1,'user' : user, "title" : title ,"serve" : serve,"description" : description ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein }, "date_add" : date, "update" : ''}
        x = mycol.insert_one(data)
    return data

def trans_ingredients(ingredients):
        translatedText = []
        client = translate.TranslationServiceClient()
        parent = client.location_path(project_id, "global")
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

def add_user(username, email, password, name, surname, food_allergy, age, weight, height, admin, date, image ):
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
                'image' : image
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
                'image' : image
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
    #print(x)

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
        #name = request.json['name']
        name = ''
        #surname = request.json['surname']
        surname = ''
        #food_allergy = request.json['food_allergy']
        food_allergy = []
        #age = request.json['age']
        age = ''
        #weight = request.json['weight']
        weight = ''
        #height = request.json['height']
        height = ''
        image = ''
        date = datetime.datetime.now()
        if request.json['admin'] == 'User':
            admin = 'False'
        else:
            admin = 'True'
        add_user(username, email, password, name, surname, food_allergy, age, weight, height, admin, date, image )
        add_api_key(username)
        data = mycol.find({ "email" : email })
        return dumps(data)
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
            image = request.json['image']
            height = request.json['height']
            weight = request.json['weight']
            foodallergens = request.json['foodallergens']
            date = datetime.datetime.now()
            try:
                mycol.update_one({ '_id': int(_id) }, { '$set': { 'name': name, 'surname': surname, 'email': email, 'age': age, 'image': image, 'height': height, 'weight': weight, 'food_allergy': foodallergens, 'update': date } })
                #print('true')
                return 'true'
            except:
                #print('false')
                return 'false'

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
            menu = menucol.find({ "_id" : request.args['id'] }).sort([('date_add' , -1)]).limit(limit).skip(skip)
        else:
            menu = menucol.find({ "_id" : request.args['id'] }) .sort([('date_add', -1)])          
        #print('len = ',menucol.find({ "ingredients.name" : { '$regex' : name} }).count())
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
        if 'name' in request.args and 'skip' in request.args:
            name = str(request.args['name']) 
        else:
            return 'Error: No name field provided. Please specify a name.'
        menucol = connectdb('menu')
        if 'limit' in request.args and 'skip' in request.args:
            skip = int(request.args['skip'])
            limit = int(request.args['limit'])
            menu = menucol.find({ "ingredients.name" : { '$regex' : name} } or  {"title" : { "$regex" : name } } ).sort([('_id' , -1)]).limit(limit).skip(skip)
        else:
            menu = menucol.find({ "ingredients.name" : { '$regex' : name} } or  {"title" : { "$regex" : name } } )           
        #print('len = ',menucol.find({ "ingredients.name" : { '$regex' : name} }).count())
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
        print('len = ',menucol.find({ "ingredients.name" : { '$in' : name } }).count())
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

'''@app.route('/api/menu-detail/total-menu', methods=['GET'])
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
        return str(total)'''

'''@app.route('/api/menu-detail/limit-menu', methods=['GET'])
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
        mycol = connectdb('menu')
        menu = mycol.find().limit(20).skip(skip)
        #result = []
        #for send in menu:
        #    result.append(send)
        #print(type(dict(result)))
        #print(type(json.dumps(menu)))
        return dumps(menu,ensure_ascii=False)
        #return dumps(menu)'''

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
                receipe = pd.read_excel(file, dtype = 'str')
                print(len(receipe))
                for i in range(len(receipe)):
                    menu['title'].append(receipe['menu_name'][i]) 
                    menu['serve'].append(receipe['serve'][i]) 
                    menu['preparations'].append(receipe['preparations'][i].split(',')) 
                    menu['ingredients'].append(receipe['ingredients'][i].split(',')) 
                    menu['image'].append(receipe['image'][i]) 
                    menu['reference'].append(receipe['reference'][i]) 
                print(menu)
        data = {}
        for tmp in range(len(receipe)):
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

            trans = trans_ingredients(menu['ingredients'][tmp])
            
            get_nutrition(trans, menu['serve'][tmp])
            data[tmp] = insert_receipe(menu['title'][tmp], menu['serve'][tmp], menu['preparations'][tmp], ing, menu['image'][tmp], menu['reference'][tmp], calories, carbohydrates, cholesterols, fats, proteins)
        print(type(data))
        return data

@app.route('/api/add-receipe', methods=['POST'])
def add_receipe():
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
        if not request.json or not 'title' and 'serve' and 'ingredients' and 'preparations' and 'image' and 'reference' and 'user' in request.json:
            return 'Error: Missing Informations. Please specify all Informations.'
        else:
            title = request.json['title']
            serve = request.json['serve']
            description = request.json['description']
            ingredients = request.json['ingredients']
            preparations = request.json['preparations']
            image = request.json['image']
            reference = ''
            date = datetime.datetime.now();
            user = request.json['user']

        for i in ingredients:
            ingdata = i['name']+' '+i['value']+' '+i['unit']
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
        return insert_receipe(title, serve, description, preparations, ingredients, image, reference, date, calories, carbohydrates, cholesterols, fats, proteins, user)

#if __name__ == '__main__':
#    app.run()  
    