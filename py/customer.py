import MySQLdb
import re
import time
import datetime
import db_rap2
from db_rap2 import dbTable as dbTab
from random import randrange as rr

class Customer():
    def __init__(self, username, password, firstname, lastname, email, conn=None, admin_level=0, mi='J', debug=0):
        self.conn = conn
        regerr = 0
        self.table = dbTab("customer",self.conn)
#        retTup = self.table.get(("customer_id","account_id","password","firstname","email","admin_level","mi"), ("username","lastname"), (username, lastname))
        retTup2 = self.table.getJoin(("customer.customer_id","customer.account_id","customer.password","customer.firstname","customer.email","customer.admin_level","customer.mi","account.status","account.balance"), ("username","lastname"), (username, lastname),"account", "account_id")
        self.customer_id = 0
        self.account_id = 0
        self.new_customer = 0
        self.status = 0
        self.balance = 0.0  
        if retTup2:  # customer exists
            self.username = username
            self.lastname = lastname
            self.password = retTup2[0][2]
            self.firstname = retTup2[0][3]
            self.email = retTup2[0][4]
            self.admin_level = retTup2[0][5]
            self.mi = retTup2[0][6]
            self.customer_id = retTup2[0][0]
            self.account_id = retTup2[0][1]
            self.new_customer = 0
            self.status = retTup2[0][7]
            self.balance = retTup2[0][8]
            self.last_betid = 0
        else:	# new customer
            self.username = username
            self.lastname = lastname
            self.password = password
            self.firstname = firstname
            self.email = email
            self.admin_level = admin_level
            self.mi = mi
            # self.customer_id and self.account_id are set in register
            retTup3 = self.register()
            self.new_customer = 1
            if retTup3:
                self.customer_id = retTup3[0]
                self.account_id = retTup3[1]
                self.new_customer = 1
                self.status = retTup3[2]
                self.balance = retTup3[3]
            else:
                regerr = 1
            self.last_betid = 0
        self.debug = debug
        if regerr:
            print "regerr on customer %s %s with username %s" % (self.firstname, self.lastname, self.username)
        elif self.debug and self.new_customer:
            print "new customer %s %s has username %s with customer id = %s and account id = %s" % (self.firstname, self.lastname, self.username, self.customer_id, self.account_id)
        elif self.debug:
            print "existing customer %s %s has username %s with customer id = %s and account id = %s" % (self.firstname, self.lastname, self.username, self.customer_id, self.account_id)
        
    def register(self):
        customer_id = self.table.put(("username","password","firstname","lastname","mi","email","admin_level"),(self.username,self.password,self.firstname,self.lastname,self.mi,self.email,self.admin_level))
        self.account_id = 0
        rettup = ()
        #update customer table with hardcoded shit.
        if customer_id > 0:
            street_address = str(rr(300)) + " shart shorts street"
            self.table.update(("address1","address2","city","state","zipcode","country","phone"),(street_address, "", "Spanks", "NM", "44532", "USA", "18003287448"), "customer_id", customer_id)
            create_date = str(datetime.datetime.now())
            ind = create_date.find('.')
            if ind >= 0:
                oldTableName = self.table.table
                self.table.table = "account"
                create_date2 = create_date[0:ind]
                account_id = self.table.put(("create_date","balance","status","type"), (create_date2,0.0,1,1))
                if account_id > 0:
                    self.table.table = "customer"
                    self.table.update("account_id",account_id,"customer_id", customer_id)
                rettup = (customer_id,account_id,1,0.0)
                self.table.table = oldTableName
        return rettup

    def addEntries(self,nameArr,valArr,entryNum,val):
        if val:
            colname = "pick_entry" + str(entryNum)
            nameArr.append(colname)
            valArr.append(val)

    def makeBet(self,pool_acct_id,amount,pick_entry1,pick_entry2=0,pick_entry3=0,pick_entry4=0,pick_entry5=0,pick_entry6=0):
        reterr = 1 # 0 is good, otherwise error.
        transid = 0
        ttype = 3
        if amount > self.balance:
            reterr = 2
        else:
            procargs = (self.account_id,pool_acct_id,amount,ttype,transid)
            transid2 = self.table.callBetTransaction(procargs,self.account_id)
            if transid2 > 0:
                oldTableName = self.table.table
                self.table.table = "bet";
                columnArr = ["trans_id","status","pick_entry1"]
                if isinstance(pick_entry1, tuple):
                    columnValues = [transid2,2,pick_entry1[0]]
                    for i in range(len(pick_entry1)):
                        if not i:
                            continue
                        self.addEntries(columnArr,columnValues,i+1,pick_entry1[i])
                else:
                    columnValues = [transid2,2,pick_entry1]
                    self.addEntries(columnArr,columnValues,2,pick_entry2)
                    self.addEntries(columnArr,columnValues,3,pick_entry3)
                    self.addEntries(columnArr,columnValues,4,pick_entry4)
                    self.addEntries(columnArr,columnValues,5,pick_entry5)
                    self.addEntries(columnArr,columnValues,6,pick_entry6)
                columnTup = tuple(columnArr)
                valuesTup = tuple(columnValues)
                self.last_betid = self.table.put(columnTup,valuesTup)
                self.table.table = "account"
                retTup = self.table.get(("status","balance"),"account_id", self.account_id)
                if retTup:
                    self.status = retTup[0][0]
                    self.balance = retTup[0][1]                
                self.table.table = oldTableName
                reterr = 0
            else: # insufficient funds
                reterr = 3
        return reterr

    def makeDeposit(self,amount):
        reterr = 1 # 0 is good, otherwise error.
        transid = 0
        ttype = 1
        fake_id = 0
        procargs = (1,self.account_id,amount,transid)
        transid2 = self.table.callDepTransaction(procargs,self.account_id)
        if transid2 > 0:
            oldTableName = self.table.table            
            self.table.table = "account"
            retTup = self.table.get(("status","balance"),"account_id", self.account_id)
            if retTup:
                self.status = retTup[0][0]
                self.balance = retTup[0][1]                
            self.table.table = oldTableName
            reterr = 0
        return reterr
     
