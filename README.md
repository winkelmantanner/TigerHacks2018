This project uses newsapi to get news based on keywords and it gets 20 articles at a time.
Then it uses the code of the third placer from the fake news challenge (FNC) to compare the articles
to each other and scores them based on which one agrees with the highest fraction of the others.

Requires python 3, but NOT python 3.7 since TensorFlow does not work with python 3.7.

There may be a requirements.txt file, but we aren't keeping it up to date.
You will need to use
```pip<version> install <package_name>```
to install packages like tensorflow, numpy, sklearn, flask, etc. onto the correct version of python.

web.py is the main file which flask should target.

Run using
```python<version> -m flask run```

The first request should take the app a long time to respond to because it has to load over 4 gigabytes of TensorFlow models.
But after that it should be fast enough.

![What it looks like](https://raw.githubusercontent.com/winkelmantanner/TigerHacks2018/tanner/images/Screen%20Shot%202018-10-14%20at%209.10.24%20AM.png?raw=true)