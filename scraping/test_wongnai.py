# This Python file uses the following encoding: utf-8

from urllib.request import ProxyHandler, build_opener, install_opener, Request, urlopen
import urllib.parse
from bs4 import BeautifulSoup as soup
import os
from google.cloud import translate
import requests
import json
import re
import time
import random
import pymongo
from selenium import webdriver
from selenium.webdriver.firefox.options import Options

credential_path = "C:\\Users\\shabu\Desktop\\fluttertest\\foodapi-68021c8d36da.json"
os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = credential_path

get_nutrition_link = "https://api.edamam.com/api/nutrition-details?app_id=20334a52&app_key=19c996cb1f61d2d9f2a71efbbc87c97d"
success = 0
fail = 0
name = ''
value = ''
unit = ''

title_class = 'sc-1s3pom6-0 jsSyKa'
serve_class = 'e4xsl4-1 bwjFPx'
ing_class = 'e4xsl4-2 lmAAgG'
prep_class = 'sc-1cffmbx-1 bDilCH'

delay = []
for i in range(40):
    delay.append(40+i)

options = Options()
options.add_argument('-headless')
profile = webdriver.FirefoxProfile()
driver = webdriver.Firefox(profile,options=options)

def connectdb(DBname):
    #myclient = pymongo.MongoClient("mongodb://localhost:27017/")
    password = urllib.parse.quote_plus('L1verp@@l')
    myclient = pymongo.MongoClient("mongodb://cheasel:%s@preproject-shard-00-00-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-01-i1n8s.gcp.mongodb.net:27017,preproject-shard-00-02-i1n8s.gcp.mongodb.net:27017/test?ssl=true&replicaSet=Preproject-shard-0&authSource=admin&retryWrites=true&w=majority"%(password))
    mydb = myclient["Food"]
    return mydb[DBname]

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

class WN_Recipe:
    project_id="future-name-268108"
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

    WN_all_url = []
    WN_url = []
    menuName = []
    url = 'https://www.wongnai.com/recipes?sort.type=0&type=1'
    title = ''
    serve = ''
    ingredients = []
    ingredients2 = []
    preparations = []
    image = ''
    reference = ''
    translatedText = []
    nutrition_data = []
    calories = []
    carbohydrates = []
    fat = []
    protein = []
    cholesterol = []
    ing = []

    def openUrl(self, url):
        #print('attempting to build from page: '+self.url)
        #print(self.user_agent)
        driver.get(url)
        #time.sleep(random.choice(delay))
        driver.implicitly_wait(80)

    '''def connectdb(self, DBname):
        myclient = pymongo.MongoClient("mongodb://localhost:27017/")
        mydb = myclient["foodDB"]
        return mydb[DBname]'''

    def convert_text(self,s):
        new = ''
        for x in s:
            new += x
        return new

    def button_click(self):
        xpath = '/html/body/div[1]/div/div[1]/div[3]/div/div/div[1]/div[1]/div/div[2]/div/div/div[2]/button'
        btn = driver.find_element_by_xpath(xpath)
        btn.click()

    def get_menuUrl(self, temp):
        for i in temp.find_all('div', {'class': '_21btc6ycbuwmnmRpkhCZGl sc-5qrr3t-2 fJgfQS'}):
            for j in i.find_all('a'):
                self.WN_all_url.append('https://www.wongnai.com/'+j.get('href'))
                #print(j.get('href'))
    
    def get_menuName(self, temp):
        for i in temp.find_all('h2', {'class': 'sc-5qrr3t-6 klzfDm'}):
            for j in i.find_all('a'):
                self.menuName.append(self.convert_text(re.findall('[ก-๙A-Za-z(-) ]', j.text)).strip())

    def duplicate_check(self, i):
        mycol = connectdb("menu")
        if(mycol.find({"title": self.menuName[i]}).count() == 0):
            self.WN_url.append(self.WN_all_url[i])

    def get_title(self, page):
        #return page.find('div', {'class': 'sc-1s3pom6-0 jsSyKa'}).h1.text
        return page.find('div', {'class': title_class}).h1.text

    def get_serve(self, page):
        try:
            if(len(self.convert_text(re.findall('[0-9]', page.find('div', {'class': serve_class }).text)).strip()) > 0 ):
                return self.convert_text(re.findall('[0-9]', page.find('div', {'class': serve_class }).text)).strip()
                # return self.convert_text(re.findall('[0-9]', page.find('div', {'class': 'sc-1waccvv-1 kvoEeZ'}).text)).strip()
        except Exception as x:
            return 1

    def get_ingredients(self, page):
        self.ing.clear()
        self.ingredients2.clear()
        global name
        global value
        global unit
        for i in page.find_all('li', {'class': ing_class }):
            name = ''
            value = ''
            unit = ''
            for j in i.div:
                if j.text == '':
                    value = '1'
                    unit = ''
                    self.ingredients2.append(name + value + unit)
                    self.ing.append({'name' : name, 'value': value, 'unit': unit})
                elif not re.findall(r'[0-9]+', j.text):
                    name = j.text
                else:
                    temp = j.text.split()
                    if len(temp) > 1:
                        value = temp[0]
                        unit = temp[1]
                    else:
                        value = self.convert_text(re.findall('[/-9 -]', temp[0])).strip()
                        unit = self.convert_text(re.findall('[ก-๙]', temp[0])).strip()
                    self.ingredients2.append(name + value + unit)
                    self.ing.append({'name' : name, 'value': value, 'unit': unit})
        return self.ing
    
    def get_preparations(self, page):
        return [self.convert_text(re.findall('[ก-๙A-Za-z(-)/-9 ]', i.text)).strip() for i in page.find_all('li',{"class": prep_class })]

    def get_image(self, page):
        return page.find('img',{'alt': self.get_title(page)}).get('srcset')

    def trans_ingredients(self):
        self.translatedText.clear()
        client = translate.TranslationServiceClient()
        parent = client.location_path(self.project_id, "global")
        for i in range(len(self.ingredients2)):
            response = client.translate_text(
                parent=parent,
                contents=[self.ingredients2[i]],
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

    def build_recipe(self, page):
        self.title = self.convert_text(re.findall('[ก-๙A-Za-z(-) ]', self.get_title(page))).strip()
        #print()
        time.sleep(3)
        self.serve = self.get_serve(page)
        time.sleep(4)
        self.ingredients = self.get_ingredients(page)
        time.sleep(3)
        self.preparations = self.get_preparations(page)
        time.sleep(2)
        self.image = self.get_image(page).split(' ')[0]
        time.sleep(3)
        self.trans_ingredients()
        time.sleep(4)
        self.get_nutrition()
        time.sleep(3)
        insert_receipe(self.title, self.serve, self.preparations, self.ing, self.image, self.reference, self.calories, self.carbohydrates, self.cholesterol, self.fat, self.protein)

    def __init__(self):
        global success
        global fail
        profile.set_preference("general.useragent.override", random.choice(self.user_agent_list))
        self.openUrl(self.url)
        for i in range(1):
            print('page ',int(i)+1)
            self.button_click()
            time.sleep(3)
        temp = soup(driver.page_source, 'html.parser')
        self.get_menuUrl(temp)
        self.get_menuName(temp)
        for i in range(len(self.menuName)):
            self.duplicate_check(i)
            print('menu : ',i)
        for j in self.WN_url:
            print('attempting to build from page: '+j)
            try:
                self.openUrl(j)
                self.reference = j
                self.build_recipe(soup(driver.page_source, 'html.parser'))
                time.sleep(random.choice(delay))
                success += 1
                print('all : ',len(self.WN_url))
                print('success : ',success)
                print('fail : ',fail)
            except Exception as x:
                print('Could not build from %s, %s'%(j,x))
                time.sleep(random.choice(delay)+90)
                fail += 1
                print('all : ',len(self.WN_url))
                print('success : ',success)
                print('fail : ',fail)

if __name__ == '__main__':
    WN_Recipe()
    print('success : ',success)
    print('fail : ',fail)
