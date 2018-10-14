import os
import random
import json
import pred
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


def generate_index_pairs(size):
    for outer_index in range(size):
        for inner_index in range(size):
            if outer_index != inner_index:
                yield outer_index, inner_index

def evaluate_articles_against_each_other(all_articles):
    with open(pred.file_test_instances, 'w') as stance_file, open(pred.file_test_bodies, 'w') as body_file:
        body_file.write('Body ID,articleBody\n')
        for index, content_article in enumerate(all_articles['articles']):
            body_file.write(str(index) + ",\"" + str(content_article['content']).replace('\"','') + '\"\n')
        stance_file.write('Headline,Body ID\n')
        for stance_article_index, content_article_index in generate_index_pairs(len(all_articles['articles'])):
            stance_file.write('\"' + str(all_articles['articles'][stance_article_index]['content']).replace('\"','') + "\"," + str(content_article_index) + '\n')
    result = pred.run()
    point_count = [0 for k in range(len(all_articles['articles']))]
    appearance_count = [0 for k in range(len(all_articles['articles']))]
    index = 0
    for stance_article_index, content_article_index in generate_index_pairs(len(all_articles['articles'])):
        verdict = result[index]
        appearance_count[stance_article_index] += 1
        appearance_count[content_article_index] += 1
        if verdict == 0: # if they agree
            point_count[stance_article_index] += 1
            point_count[content_article_index] += 1
        elif verdict == 1: # disagree
            point_count[stance_article_index] -= 1
            point_count[content_article_index] -= 1
        index += 1
    scores = [point_count[i] / appearance_count[i] for i in range(len(all_articles['articles']))]
    print(scores)
    for index, article in enumerate(all_articles['articles']):
        article['agreement_score'] = scores[index]





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

    # print("NUM ARTICLES: " + str(len(all_articles['articles'])))

    # /v2/sources
    sources = newsapi.get_sources()

    evaluate_articles_against_each_other(all_articles)

    
    #print(sources)
    # print(type(all_articles))
    #print(top_headlines)
    #print(newsapi)
    
    return render_template('home.html' , sources=sources , all_articles=json.dumps(all_articles) , top_headlines=top_headlines , newsapi=newsapi)

@app.route('/about')
def about():
    return render_template('about.html')

@app.route('/test_text', methods = ['POST', 'GET'])
def test_text():
    content = request.form['content']
    print(content)
    return render_template('test_text.html')

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

    evaluate_articles_against_each_other(all_articles)


    # for a in all_articles['articles']:
    #     print(len( a['content']))

    # /v2/sources
    sources = newsapi.get_sources()
    
    #print(sources)
    print(type(all_articles))
    #print(top_headlines)
    #print(newsapi)
    
    return render_template('home.html' , sources=sources , all_articles=json.dumps(all_articles) , top_headlines=top_headlines , newsapi=newsapi)

app.run()
