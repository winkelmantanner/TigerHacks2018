import os
import random
import json
from flask import Flask, request, session, g, redirect, url_for, abort, render_template, flash, send_file
from werkzeug.utils import secure_filename
from os import path
from newsapi import NewsApiClient

UPLOAD_FOLDER ='downloads'
ALLOWED_EXTENSIONS = set(['.txt', '.pdf', '.png', '.jpg', '.jpeg', '.gif', '.docx'])
app = Flask('DataBase')
app.secret_key = 'secret'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# This file create each individual webpage for our the projec by rendering the HTML that we 
# wrote in order to output the information we want

@app.route('/')
def home():
    # Init
    newsapi = NewsApiClient(api_key='a9288315ab104f7aa9564ca6d08b8ce4')

    # /v2/top-headlines
    top_headlines = newsapi.get_top_headlines(q='America',
                                            language='en')

    # /v2/everything
    all_articles = newsapi.get_everything(q='America',
    language='en')

    # /v2/sources
    sources = newsapi.get_sources()
    
    #print(sources)
    print(type(all_articles))
    #print(top_headlines)
    #print(newsapi)
    
    return render_template('home.html' , sources=sources , all_articles=json.dumps(all_articles) , top_headlines=top_headlines , newsapi=newsapi)

@app.route('/about')
def about():
    return render_template('about.html')

# these two request functions let users input information about exams 
@app.route('/request', methods = ['POST', 'GET'])
def request_exam():
    return render_template('request.html')

@app.route('/display', methods = ['POST', 'GET'])
# this is the display for normal users
def display_exam():
    Subject = request.form['Subject']
    if(str(Subject).isspace() or Subject == ''):
        Subject = 'America'
        print(Subject)
    # Init
    newsapi = NewsApiClient(api_key='a9288315ab104f7aa9564ca6d08b8ce4')

    # /v2/top-headlines
    top_headlines = newsapi.get_top_headlines(q=str(Subject),
                                            language='en')

    # /v2/everything
    all_articles = newsapi.get_everything(q=str(Subject),
    language='en')

    # /v2/sources
    sources = newsapi.get_sources()
    
    #print(sources)
    print(type(all_articles))
    #print(top_headlines)
    #print(newsapi)
    
    return render_template('home.html' , sources=sources , all_articles=json.dumps(all_articles) , top_headlines=top_headlines , newsapi=newsapi)

app.run()
