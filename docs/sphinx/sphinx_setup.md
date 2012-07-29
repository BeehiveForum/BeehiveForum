# Project Beehive Forum Sphinx Integration

## 0. Requirements

To enable searching via Sphinx on your Beehive Forum you are going 
to need:

 - Sphinx Search version 2.0.4
 - Beehive Forum 1.2.0.
 - The ability to edit sphinx.conf and add new sources and indexes.

## 1. Install Sphinx

Beehive Forum requires Sphinx 2.0.4 or newer. If your package manager
doesn't provide a new enough version of Sphinx (or your OS doesn't 
provide a package manager) you can download the source or binaries 
from: <http://sphinxsearch.com/downloads/release/>

Once you have downloaded Sphinx follow the instructions for 
compiling and installing it for your OS.

## 2. Setting up Sphinx

To make Beehive work with Sphinx you need to enable MySQL protocol 
support, hence the requirement for 2.0.4. To do this you need to 
ensure your sphinx.conf contains a listen directive which reads:

        listen = 9306:mysql41

Port 9306 is what Sphinx will listen on for MySQL protocol 
connections. You can change this if you want, but don't change it 
to the same port as the real MySQL as that would be really, really
silly.

First thing you need to do is set up the global 'searchd' section
of the sphinx.conf. Below you will find an example which you can use
as a base. If you plan to customise the sphinx.conf, please ensure it
contains the required listen directive otherwise your Beehive Forum 
will be unable to communicate with Sphinx.

        searchd
        {
            listen              = 127.0.0.1:9312
            listen              = 127.0.0.1:9306:mysql41

            read_timeout        = 5
            client_timeout      = 30

            max_children        = 10
            max_matches         = 1000
            
            pid_file            = /var/run/sphinxsearch/searchd.pid
            log                 = /var/log/sphinxsearch/searchd.log

            seamless_rotate     = 1
            preopen_indexes     = 0
            unlink_old          = 1

            workers             = threads
        }
    

## 3. Creating a Sphinx source

To allow Sphinx to index your Beehive Forum posts you need to 
create at least two sources. These sources need to be set-up so 
that Sphinx's indexer knows where to find the posts in your 
Beehive Forum's database.

Beehive Forum's Sphinx integration makes use of delta+main 
sources and indexes, hence the two sources. The idea is to set 
up these two sources (and two indexes), with one main index 
being used for the older posts and a delta for the new posts 
created today.

This allows the delta index to be reindexed very frequently and
at a reduced cost (search downtime, resources consumed, etc.) 
compared to reindexing the entire forum every time which would 
take significantly longer.

When searching Sphinx, Beehive looks for indexes named with the 
WEBTAG (the prefix for each table in your Beehive Forum database) 
of the current forum for the main index and the WEBTAG with _DELTA 
appended to the end of it for the delta index. By doing this, 
your Beehive Forum requires less configuration in order to get it 
to work with Sphinx.

For the sake of simplicity, although it is not neccesary to do so,
we also name the sources the same.

In this example below the WEBTAG used is DEFAULT, so the sources
are named DEFAULT and DEFAULT_DELTA. If your WEBTAG is different 
be sure to substitue it where applicable. Also note, if you have 
more than one forum (WEBTAG) you will need to create a main and
delta source for each of them:

        source DEFAULT
        {
            type                = mysql

            sql_host            = localhost
            sql_user            = beehiveforum
            sql_pass            = password
            sql_db              = beehiveforum
            sql_port            = 3306

            mysql_connect_flags = 32

            sql_query_pre       = SET NAMES utf8

            sql_query_pre       = SET SESSION time_zone = '+0:00'
            
            sql_query_pre       = UPDATE DEFAULT_POST_SEARCH_ID SET INDEXED = UTC_TIMESTAMP()

            sql_query           = \
                    SELECT DEFAULT_POST_SEARCH_ID.SID AS id, \
                           COALESCE(DEFAULT_THREAD.TITLE, '') AS title, \
                           COALESCE(DEFAULT_POST_CONTENT.CONTENT, '') AS content, \
                           1 AS forum, \
                           COALESCE(DEFAULT_THREAD.FID, 0) AS fid, \
                           COALESCE(DEFAULT_THREAD.TID, 0) AS tid, \
                           COALESCE(DEFAULT_POST.PID, 0) AS pid, \
                           COALESCE(DEFAULT_THREAD.BY_UID, 0) AS by_uid, \
                           COALESCE(DEFAULT_POST.FROM_UID, 0) AS from_uid, \
                           COALESCE(DEFAULT_POST.TO_UID, 0) AS to_uid, \
                           UNIX_TIMESTAMP(DEFAULT_POST.CREATED) AS created \
                      FROM DEFAULT_POST \
                INNER JOIN DEFAULT_POST_SEARCH_ID ON (DEFAULT_POST_SEARCH_ID.TID = DEFAULT_POST.TID AND DEFAULT_POST_SEARCH_ID.PID = DEFAULT_POST.PID) \
                INNER JOIN DEFAULT_POST_CONTENT ON (DEFAULT_POST_CONTENT.TID = DEFAULT_POST.TID AND DEFAULT_POST_CONTENT.PID = DEFAULT_POST.PID) \
                INNER JOIN DEFAULT_THREAD ON (DEFAULT_THREAD.TID = DEFAULT_POST.TID) \
                INNER JOIN DEFAULT_FOLDER ON (DEFAULT_FOLDER.FID = DEFAULT_THREAD.FID) \
                     WHERE DEFAULT_POST_SEARCH_ID.INDEXED IS NOT NULL

            sql_attr_uint       = forum
            sql_attr_uint       = fid
            sql_attr_uint       = tid
            sql_attr_uint       = pid
            sql_attr_uint       = by_uid
            sql_attr_uint       = from_uid
            sql_attr_uint       = to_uid

            sql_attr_timestamp  = created

            sql_query_killlist  = \
                    SELECT DEFAULT_POST_SEARCH_ID.SID AS id \
                      FROM DEFAULT_POST \
                INNER JOIN DEFAULT_POST_SEARCH_ID ON (DEFAULT_POST_SEARCH_ID.TID = DEFAULT_POST.TID AND DEFAULT_POST_SEARCH_ID.PID = DEFAULT_POST.PID) \
                     WHERE DEFAULT_POST.EDITED >= @last_reindex
        }

        source DEFAULT_DELTA : DEFAULT
        {
            sql_query_pre       = SET NAMES utf8

            sql_query_pre       = SET SESSION time_zone = '+0:00'

            sql_query           = \
                    SELECT DEFAULT_POST_SEARCH_ID.SID AS id, \
                           COALESCE(DEFAULT_THREAD.TITLE, '') AS title, \
                           COALESCE(DEFAULT_POST_CONTENT.CONTENT, '') AS content, \
                           1 AS forum, \
                           COALESCE(DEFAULT_THREAD.FID, 0) AS fid, \
                           COALESCE(DEFAULT_THREAD.TID, 0) AS tid, \
                           COALESCE(DEFAULT_POST.PID, 0) AS pid, \
                           COALESCE(DEFAULT_THREAD.BY_UID, 0) AS by_uid, \
                           COALESCE(DEFAULT_POST.FROM_UID, 0) AS from_uid, \
                           COALESCE(DEFAULT_POST.TO_UID, 0) AS to_uid, \
                           UNIX_TIMESTAMP(DEFAULT_POST.CREATED) AS created \
                      FROM DEFAULT_POST \
                INNER JOIN DEFAULT_POST_SEARCH_ID ON (DEFAULT_POST_SEARCH_ID.TID = DEFAULT_POST.TID AND DEFAULT_POST_SEARCH_ID.PID = DEFAULT_POST.PID) \
                INNER JOIN DEFAULT_POST_CONTENT ON (DEFAULT_POST_CONTENT.TID = DEFAULT_POST.TID AND DEFAULT_POST_CONTENT.PID = DEFAULT_POST.PID) \
                INNER JOIN DEFAULT_THREAD ON (DEFAULT_THREAD.TID = DEFAULT_POST.TID) \
                INNER JOIN DEFAULT_FOLDER ON (DEFAULT_FOLDER.FID = DEFAULT_THREAD.FID) \
                     WHERE DEFAULT_POST_SEARCH_ID.INDEXED IS NULL
        }    


## 4. Creating a Sphinx Index

In addition to the searchd and source definitions you also need to 
create an index for each source. An index is where Sphinx will store 
the post data that Beehive will search. As with the source we are 
using the WEBTAG as the name of the indexes. Because we are using 
the delta+main index scheme we also need to create two indexes,
one for each of the sources we created above:

        index DEFAULT
        {
            type                = plain
            
            source              = DEFAULT

            path                = /var/lib/sphinxsearch/data/DEFAULT

            rt_field            = title
            rt_field            = content

            rt_attr_uint        = forum
            rt_attr_uint        = fid
            rt_attr_uint        = tid
            rt_attr_uint        = pid
            rt_attr_uint        = by_uid
            rt_attr_uint        = from_uid
            rt_attr_uint        = to_uid

            rt_attr_timestamp   = created

            charset_type        = utf-8

            html_strip          = 1
        }

        index DEFAULT_DELTA : DEFAULT
        {
            source              = DEFAULT_DELTA
            path                = /var/lib/sphinxsearch/data/DEFAULT_DELTA
        }

Please feel free to change the path directive, this is where Sphinx 
will store the physical index files, but please, please don't change
anything else about the index definition. If you do change anything 
your Beehive Forum may not be able to communicate correctly with 
Sphinx or may return no results.

Once Sphinx is all set up all that is left to do is to start the 
Sphinx daemon or service as per the Sphinx documentation for your OS.

## 5. Filling the Sphinx index

The first time you try to start Sphinx it will complain that the 
index cannot be loaded. It is therefore neccesary to run the indexer 
tool with the name of the indexes to populate:

        indexer DEFAULT DEFAULT_DELTA

If you have named your index differently, substitute it in the 
command above. Notice that we are updating both the main and delta
indexes here.

To enable periodic updating of the indexes you will need to add the 
indexer command to your crontab or scheduled tasks otherwise the 
index will be out of date.

It is recommended to update your main index daily or weekly depending
on how busy your forums are and update the delta index more 
frequently. A good starting point would be to update the delta index
every 15 minutes.

If you have more than one forum you will need to run the command 
and add relevant crontab / scheduler entries for each of their 
indexes.

Note: In older versions of Beehive Forum we used a real-time 
Sphinx index, but this caused problems with performance on heavilly 
visited sites. Now we recommend running the indexer periodically to 
have it update the indexes.

## 6. Enabling Sphinx support in Beehive Forum

To enable Sphinx support in your Beehive Forum, visit the Global 
Forum Settings of your Beehive Forum and look for the Sphinx Search 
Integration section. Here you will find 2 text fields where you can 
enter the Sphinx server address and port number.

Additionally there is a set of radio buttons to quickly and easily 
enable or disable the integration.

Once you've entered the values, scroll to the bottom and click save.

## 7. Help. It didn't work!

Don't panic! Pop over to Teh Forum at <http://www.tehforum.co.uk> and
ask for help. Please help us to help you by indicating any error 
messages you received and how far along this guide you've manage 
to get. 

Please be paitient in getting a reply, we'll try to get to you ASAP,
but please be aware that we don't monitor the forum 24/7 (it's our 
hobby, not our job), so you might have to wait for someone to reply.

If you don't get a reply without 24 hours then you can feel free to
bump the thread.