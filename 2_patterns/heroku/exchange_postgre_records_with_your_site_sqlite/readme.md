In the previous article (go one dir back) we discover how to create & setup a Postgre dbase on heroku.

In these folders you will see how to exchange the Postgre records with your site sqlite then delete the Postgre records.

I declare again the restrictions on free plan :

 - expected uptime 99.5% (< 4 hr downtime per month)
 - rows limit 10,000
 - concurrent connections limit 20
 
 
What we want to achieve is when the Postgre dbase reach more than 9000 records to backup it on sqlite dbase where is on your site and delete the records from Postgre.


![snap343](https://user-images.githubusercontent.com/3852762/28752034-271b9504-7516-11e7-98b4-e77053f2e781.png)



ps Today is the first time this process ran the log.txt -- Total Execution Time: 2.0911996324857 mins

--


after 3months :

as more fields added to Postgre, the transaction now reach the 3.4mins, I came up with new idea of how to transfer the recordset to your server. The method is to use the bzip2 (where is enabled by default on heroku.PHP installation). So the plan is at heroku select the records and dump it (bzip2) to a file, then upload the file to your server unwrap it and import the records http://www.pipiscrew.com/2017/11/servera-wrap-bzip2-database-recordset-serverb-unwrap-it/ .


A test gave me : 
```sh
3959 records -bzip2- 1.63mb => 302kb
```
