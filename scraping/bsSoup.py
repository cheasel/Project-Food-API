#from urllib.request import ProxyHandler, build_opener, install_opener, Request, urlopen
from bs4 import BeautifulSoup as soup
import os
from google.cloud import translate
import urllib.parse
import requests
import json
import re
import time
import random
import pymongo
from selenium import webdriver
from selenium.webdriver.firefox.options import Options

get_nutrition_link = "https://api.edamam.com/api/nutrition-details?app_id=20334a52&app_key=19c996cb1f61d2d9f2a71efbbc87c97d"
CP_url = 'https://cookpad.com/th'

user_agent_list = ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36',
'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36',
'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/70.0',
'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36 OPR/64.0.3417.73',
'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.70 Safari/537.36 OPR/64.0.3417.73',
'Mozilla/5.0 (Windows NT 10.0; Trident/7.0; rv:11.0) like Gecko'
]

credential_path = "C:\\Users\\shabu\Desktop\\fluttertest\\foodapi-68021c8d36da.json"
os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = credential_path

no_nutrition = 0
ok_nutrition = 0
duplicate_nutrition = 0

CP_menu_url_temp = []
CP_menu_url = []
CP_menu = []
menu_check = []

options = Options()
options.add_argument('-headless')
driver = webdriver.Firefox(options=options)

def connectdb(DBname):
    myclient = pymongo.MongoClient("mongodb://localhost:27017/")
    mydb = myclient["Food"]
    return mydb[DBname]

def convert_text(s):
    new = ''
    for x in s:
        new += x
    return new

def insert_receipe(title, serve, preparations, ingredients, image, reference, calories, carbohydrates, cholesterol, fat, protein):
    mycol = connectdb("menu")
    if(mycol.find().count() == 0):
        data = { '_id' : 1,'user' : '', "title" : title ,"serve" : serve ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein } }
        x = mycol.insert_one(data)
    else:
        num = mycol.find({}, {'name' : 0}).sort([('_id' ,-1)]).limit(1)
        data = { '_id' : num[0]['_id'] + 1,'user' : '', "title" : title ,"serve" : serve ,"ingredients" : ingredients ,"preparations" : preparations,"image" : image,"reference" : reference,"nutrition" : {"calories" : calories ,"carbohydrates" : carbohydrates ,"cholesterol" : cholesterol ,"fat" : fat ,"protein" : protein }}
        x = mycol.insert_one(data)
    print(x)

def insert_ingredient(ing):
    mycol = connectdb('ingredients')
    if(mycol.find({'name': ing}).count() == 0):
        if(mycol.find().count() == 0):
            data = { '_id' : 1, 'name' : ing}
            x = mycol.insert_one(data)
        else:
            num = mycol.find({}, {'name' : 0}).sort([('_id' ,-1)]).limit(1)
            data = { '_id' : num[0]['_id'] + 1, 'name' : ing}
            x = mycol.insert_one(data)
    else:
        print('duplicate ingredient')

class CP_Recipe:
    project_id="future-name-268108"
    user_agent = random.choice(user_agent_list)
    hdr = {'accept': 'test/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'referer': 'http://www.google.com/',
    'user-agent': user_agent}
    old_title = ''
    title = ''
    serve = ''
    image = ''
    ingredients = []
    ing = []
    preparations = []
    reference = []
    translatedText = []
    nutrition_data = []
    calories = []
    carbohydrates = []
    fat = []
    protein = []
    cholesterol = []
    percent = 0
    remove = []
    
    def get_title(self, page):
        return page.find('h1', {'itemprop': 'name'}).text
    
    def get_serve(self, page):
        try:
            return int(page.find('div', {'class': 'text-secondary mt-2'}).text.strip().split()[0])
        except:
            return 1
        
    def get_ingredients(self, page):
        return [i.text.strip() for i in page.findAll('div', itemprop='ingredients')]
    
    def get_preparations(self, page):
        return [i.text.strip() for i in page.findAll('div',{"itemprop":"recipeInstructions"})]
    
    def get_image(self, page):
        return page.find('img',{'alt': 'รูปหลักของสูตร '+self.old_title}).get('src')

    def trans_ingredients(self):
        self.translatedText.clear()
        client = translate.TranslationServiceClient()
        parent = client.location_path(self.project_id, "global")
        for i in range(len(self.ingredients)):
            response = client.translate_text(
                parent=parent,
                contents=[self.ingredients[i]],
                mime_type="text/plain",
                source_language_code="th",
                target_language_code="en-US",
            )
            for translation in response.translations:
                self.translatedText.append(format(translation.translated_text))

    def get_nutrition(self):
        calories = 0
        carbohydrates = 0
        fat = 0
        protein = 0
        cholesterol = 0
        for i in range(len(self.translatedText)):
            if not re.findall(r'[0-9]+', self.translatedText[i]):
                temp = '1 ' + self.translatedText[i]
                data = {"yield": self.serve, "ingr": [temp]}
            else:
                data = {"yield": self.serve, "ingr": [self.translatedText[i]]}
            self.nutrition_data = json.loads(requests.post(get_nutrition_link, json=data,headers=self.hdr).content.decode("utf_8", "ignore"))
            if len(self.nutrition_data) == 1:
               ''' print(self.translatedText[i])
                print('no')'''
            else:
                calories += self.get_calories()['quantity']
                carbohydrates += self.get_carbohydrates()['quantity']
                cholesterol += self.get_chole()['quantity']
                fat += self.get_fat()['quantity']
                protein += self.get_protein()['quantity']
        self.calories = {'quantity': calories, 'unit': 'kcal'}
        self.carbohydrates = {'quantity': carbohydrates, 'unit': 'g'}
        self.cholesterol = {'quantity': cholesterol, 'unit': 'mg'}
        self.fat = {'quantity': fat, 'unit': 'g'}
        self.protein = {'quantity': protein, 'unit': 'g'}

    def get_calories(self):
        try:
            return {"quantity" : float(self.nutrition_data['totalNutrients']['ENERC_KCAL']['quantity']) ,
                    "unit" : self.nutrition_data['totalNutrients']['ENERC_KCAL']['unit'] ,
                    "percent" : float(self.nutrition_data['totalDaily']['ENERC_KCAL']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'kcal' ,
                    "percent" : 0}
    
    def get_carbohydrates(self):
        try:
            return {"quantity" : float(self.nutrition_data['totalNutrients']['CHOCDF']['quantity']) ,
                    "unit" : self.nutrition_data['totalNutrients']['CHOCDF']['unit'] ,
                    "percent" : float(self.nutrition_data['totalDaily']['CHOCDF']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}
        
    def get_chole(self):
        try:
            return {"quantity" : float(self.nutrition_data['totalNutrients']['CHOLE']['quantity']) ,
                    "unit" : self.nutrition_data['totalNutrients']['CHOLE']['unit'] , 
                    "percent" : float(self.nutrition_data['totalDaily']['CHOLE']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'mg' ,
                    "percent" : 0}

    def get_fat(self):
        try:
            return {"quantity" : float(self.nutrition_data['totalNutrients']['FAT']['quantity']) ,
                    "unit" : self.nutrition_data['totalNutrients']['FAT']['unit'] , 
                    "percent" : float(self.nutrition_data['totalDaily']['FAT']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}
        
    def get_protein(self):
        try:
            return {"quantity" : float(self.nutrition_data['totalNutrients']['PROCNT']['quantity']) ,
                    "unit" : self.nutrition_data['totalNutrients']['PROCNT']['unit'] ,
                    "percent" : float(self.nutrition_data['totalDaily']['PROCNT']['quantity'])}
        except:
            return {"quantity" : 0 ,
                    "unit" : 'g' ,
                    "percent" : 0}  

    def clean_data(self, temp):
        return re.findall('[ก-๙A-Za-z/-9 -]',temp)

    def duplicate_check(self):
        mycol = connectdb('menu')
        if(mycol.find({'title': self.title}).count() == 0):
            insert_receipe(self.title, self.serve, self.preparations, self.ing, self.image, self.reference, self.calories, self.carbohydrates, self.cholesterol, self.fat, self.protein)
        else:
            print('duplicate menu')

    def build_recipe(self, page):
        self.old_title = self.get_title(page).strip()
        self.title = convert_text(re.findall('[ก-๙A-Za-z(-) ]', self.old_title)).strip()
        time.sleep(3)
        self.serve = self.get_serve(page)
        time.sleep(4)
        self.ingredients = self.get_ingredients(page)
        time.sleep(3)
        for i in range(len(self.ingredients)):
            self.ingredients[i] = convert_text(self.clean_data(self.ingredients[i])).strip()
        self.ing.clear()
        for i in self.ingredients:
            temp = len(i.split()) - 1
            name = ''
            if not re.findall(r'[0-9]+', i):
                name = i
                value = ''
                unit = ''
                insert_ingredient(name)
                mycol = connectdb('ingredients')
                self.ing.append({'ing_id' : (mycol.find({'name': name},{'name' : 0}))[0]['_id'], 'value' : value, 'unit' : unit})
            else:
                for j in range(len(i.split())):
                    if(i.split()[temp].isnumeric() is False ):
                        unit = i.split()[temp]
                    else:
                        value = i.split()[temp]
                        while(temp > 0):
                            temp -= 1
                            name = i.split()[temp] + name
                        insert_ingredient(convert_text(re.findall('[ก-๙A-Za-z]',name)))
                        mycol = connectdb('ingredients')
                        self.ing.append({'ing_id' : (mycol.find({'name': convert_text(re.findall('[ก-๙A-Za-z]',name))},{'name' : 0}))[0]['_id'], 'value' : value, 'unit' : unit})
                        break
                    temp -= 1
        self.preparations = self.get_preparations(page)
        time.sleep(2)
        for i in range(len(self.preparations)):
            self.preparations[i] = convert_text(self.clean_data(self.preparations[i])).strip()
        self.image = self.get_image(page) 
        time.sleep(3)
        self.trans_ingredients()
        time.sleep(4)
        self.get_nutrition()
        time.sleep(3)
        self.duplicate_check()

    def __init__(self, page):
        print('attempting to build from: '+page)
        try:
            driver.get(page)
            time.sleep(20)
            driver.implicitly_wait(80)
            self.reference = page
            self.build_recipe(soup(driver.page_source, 'html.parser'))
        except Exception as x:
            print('Could not build from %s, %s'%(page,x))
            time.sleep(20)

driver.get(CP_url)
driver.implicitly_wait(80)

xpath = '//*[@id="feed_pagination"]/a'
btn = driver.find_element_by_xpath(xpath)
btn.click()
for i in range(100):
    driver.execute_script("window.scrollTo(0,document.body.scrollHeight)")
    time.sleep(5)

page = soup(driver.page_source, 'html.parser')
for i in page.find_all('div', {'class': 'media__body'}):
    for j in i.find_all('a', {'data-action': True}):
        CP_menu_url.append('https://cookpad.com'+j.get('href'))

for i in CP_menu_url:
    CP_menu.append(CP_Recipe(i))