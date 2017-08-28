# GUI Application automation and testing library
# Copyright (C) 2006 Mark Mc Mahon
#
# This library is free software; you can redistribute it and/or
# modify it under the terms of the GNU Lesser General Public License
# as published by the Free Software Foundation; either version 2.1
# of the License, or (at your option) any later version.
#
# This library is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# See the GNU Lesser General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public
# License along with this library; if not, write to the
#    Free Software Foundation, Inc.,
#    59 Temple Place,
#    Suite 330,
#    Boston, MA 02111-1307 USA

"""
    Table and Player Class for my kick ass bot
"""

__revision__ = "$Revision: 214 $"

# a tableHand is a sequence of events at the table, involving players, game, pot. the action is action.

import MySQLdb
import re
import time

EQUALS = 0
GREATER_THAN = 1
GREATER_THAN_OR_EQUAL_TO = 2
LESS_THAN = 3
LESS_THAN_OR_EQUAL_TO = 4
NOT_EQUAL_TO = 5
BETWEEN = 6

class dbTable():
    def __init__(self, dbTableName, conn=None, host="", userName="", dbase=""):
        if not host:
            host = "localhost"
        if not userName:
            userName = "root"
        if not dbase:
            self.dbName = "fireboil_db"
        else:
            self.dbName = dbase
        if not conn:
            print "dbTable(): host = %s user = %s, passwd = ******, db = %s" % (host, userName, self.dbName)
            try:
                self.conn = MySQLdb.connect (host = host, user = userName, passwd = "rootsuit3278", db = self.dbName)
            except:
                self.conn = None
        else:
            self.conn = conn
        if self.conn:
            print "dbTable(): connection successful"
        self.table = dbTableName
        
    def setTable(self, dbTableName):
        self.table = dbTableName
        if not self.conn:
            try:
                self.conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = self.dbName)
            except:
                self.conn = None
        
    def getTable(self):
        return self.table
        
    def put(self, FieldTup, valTup):
        last_rowid = 0
        val2Arr = []
        str1 = ""
        str2 = ""               
        if isinstance(valTup, tuple):
            val3TupStr = "("
            for val in valTup:
                if isinstance(val, str):
                    val2 = self.getApostropheStr(val)
                    strVal = "\'" + val2 + "\',"
                    val3TupStr = val3TupStr + "\'" + val2 + "\',"
                elif isinstance(val, unicode):
                    val2 = self.getApostropheStr(val)
                    strVal = "\'" + val2 + "\',"
                    val3TupStr = val3TupStr + "\'" + val2 + "\',"
                else:
                    val3TupStr = val3TupStr + str(val) + ","
            endStr = len(val3TupStr) - 1
            val2TupStr = val3TupStr[0:endStr]
            val2TupStr = val2TupStr + ")"
            strFieldTup = str(FieldTup)
            strFieldTup2 = strFieldTup.replace('\'','')
#            val2TupStr = str(valTup)
        else:
            tuppy = (FieldTup, )
            strTuppy = str(tuppy)
            strFieldTup = strTuppy.replace('\'','')
            strFieldTup2 = strFieldTup.replace(',','')

            if isinstance(valTup, str):
                valTup2 = self.getApostropheStr(valTup)
                val2TupStr = "(" + valTup2 + ")"
            elif isinstance(valTup, unicode):
                valTup2 = self.getApostropheStr(valTup)
                val2TupStr = "(" + valTup2 + ")"
            else:            
                valTup2 = (valTup, )
                strValTup = str(valTup2)
                val2TupStr = strValTup.replace(',','')
        sqlStr = "INSERT INTO " + self.table + " " + strFieldTup2 + " VALUES " + val2TupStr
        cursor = self.conn.cursor()
        err = 0
        try:
            cursor.execute(sqlStr)
        except:
            err = 1
        if err:
            print "Database Write Error"
            print sqlStr
        else:
#            print "Database Write Good", sqlStr
            self.conn.commit()
            last_rowid = cursor.lastrowid
        cursor.close()
        return last_rowid
                
    def getJoin(self, retFieldsStr, strField, strValue, joinTable, onConnection, op=EQUALS, strValue2="", orderBy=""):
        err = 0
        retLen = 1
        whatStr = retFieldsStr
        if not retFieldsStr:
            whatStr = "*"
        elif isinstance(retFieldsStr, tuple):
            retLen = len(retFieldsStr)
            if retLen == 1:
                whatStr = retFieldsStr[0]
            elif retLen:
                whatStr = ""
                for retVal in retFieldsStr:
                    if whatStr == "DISTINCT":
                        whatStr += " " + str(retVal)
                    elif whatStr:
                        whatStr += "," + str(retVal)
                    else:
                        whatStr = str(retVal)
            else:
                whatStr = "*"
        else:
            whatStr = str(retFieldsStr)

        operList = []
        if isinstance(op, tuple):
            opList = list(op)
            for val in opList:
                if isinstance(val, str):
                    operList.append(val)
                else:
                    strVal = self.getOperatorSymbol(val)
                    operList.append(strVal)
        elif isinstance(op, str):
            oper = op
        else:
            oper = self.getOperatorSymbol(op)           
        onLeft = self.table + "." + onConnection
        onRight = joinTable + "." + onConnection
        str1 = "SELECT " + whatStr + " FROM " + self.table + " INNER JOIN " + joinTable + " ON " + onLeft + "=" + onRight
        str2 = ""
        if isinstance(strValue, tuple):
            i = 0
            for field in strField:
                val = strValue[i]
                if operList:
                    oper = operList[i]
                else:
                    oper = "="
                if i > 0:
                    str2 = str2 + " AND "
                else:
                    str2 = str2 + " WHERE "
                if isinstance(val, str):
                    val2 = self.getApostropheStr(val)
                    str2 = str2 + field + oper + "\"" + val2 + "\""
                elif isinstance(val, unicode):
                    val2 = self.getApostropheStr(val)
                    str2 = str2 + field + oper + "\"" + val2 + "\""
                else:
                    str2 = str2 + field + oper + str(val)

                if i == 0 and strValue2:    # wtf, I dont know what strValue2 is used for but i dont think it is used
                    if isinstance(strValue2, str):
                        strValue2P = self.getApostropheStr(strValue2)
                        str2 = str2 + " AND " + "\"" + strValue2P +"\""
                    elif isinstance(strValue2, unicode):
                        strValue2P = self.getApostropheStr(strValue2)
                        str2 = str2 + " AND " + "\"" + strValue2P +"\""
                    else:
                        str2 = str2 + " AND " + str(strValue2)
                i = i + 1
        else:
            if strField:
                strBool = False
                if isinstance(strValue, str):
                    strBool = True
                elif isinstance(strValue, unicode):
                    strBool = True
                else:
                    strStrValue = str(strValue)

                if strBool:
                    strValueP = self.getApostropheStr(strValue)
                    str2 = " WHERE " + strField + oper + "\"" + strValueP + "\""
                else:
                    str2 = " WHERE " + strField + oper + strStrValue

            if strValue2:
                strBool = False
                if isinstance(strValue2, str):
                    strBool = True
                elif isinstance(strValue2, unicode):
                    strBool = True
                else:
                    strStrValue2 = str(strValue2)
                if strBool:
                    strValue2P = self.getApostropheStr(strValue2)
                    str2 = str2 + " AND \"" + strValue2P + "\""
                else:
                    str2 = str2 + " AND " + strStrValue2
        cursor = self.conn.cursor()
        sqlStr = str1 + str2
        if orderBy:
            sqlStr += " ORDER BY " + orderBy
        try:
            cursor.execute(sqlStr)
        except:
            err = 1
            print "getdb: db connect error " + sqlStr
        qList = []
        if not err:
#            print sqlStr
            while (1):
                row = cursor.fetchone()
                if not row:
                    break
                if retLen == 1:
                    row2 = row[0]
                else:
                    row2 = row[:]
                qList.append(row2)
        cursor.close()
        return qList

    def get(self, retFieldsStr, strField, strValue, op=EQUALS, strValue2=""):
        err = 0
        retLen = 1
        whatStr = retFieldsStr
        if not retFieldsStr:
            whatStr = "*"
        elif isinstance(retFieldsStr, tuple):
            retLen = len(retFieldsStr)
            if retLen == 1:
                whatStr = retFieldsStr[0]
            elif retLen:
                whatStr = ""
                for retVal in retFieldsStr:
                    if whatStr == "DISTINCT":
                        whatStr += " " + str(retVal)
                    elif whatStr:
                        whatStr += "," + str(retVal)
                    else:
                        whatStr = str(retVal)
            else:
                whatStr = "*"
        else:
            whatStr = str(retFieldsStr)

        operList = []
        if isinstance(op, tuple):
            opList = list(op)
            for val in opList:
                if isinstance(val, str):
                    operList.append(val)
                else:
                    strVal = self.getOperatorSymbol(val)
                    operList.append(strVal)
        elif isinstance(op, str):
            oper = op
        else:
            oper = self.getOperatorSymbol(op)           
        str1 = "SELECT " + whatStr + " FROM " + self.table
        str2 = ""
        if isinstance(strValue, tuple):
            i = 0
            for field in strField:
                val = strValue[i]
                if operList:
                    oper = operList[i]
                else:
                    oper = "="
                if i > 0:
                    str2 = str2 + " AND "
                else:
                    str2 = str2 + " WHERE "
                if isinstance(val, str):
                    val2 = self.getApostropheStr(val)
                    str2 = str2 + field + oper + "\"" + val2 + "\""
                elif isinstance(val, unicode):
                    val2 = self.getApostropheStr(val)
                    str2 = str2 + field + oper + "\"" + val2 + "\""
                else:
                    str2 = str2 + field + oper + str(val)
                if i == 0 and strValue2:
                    if isinstance(strValue2, str):
                        strValue2P = self.getApostropheStr(strValue2)
                        str2 = str2 + " AND " + "\"" + strValue2P +"\""
                    elif isinstance(strValue2, unicode):
                        strValue2P = self.getApostropheStr(strValue2)
                        str2 = str2 + " AND " + "\"" + strValue2P +"\""
                    else:
                        str2 = str2 + " AND " + str(strValue2)
                i = i + 1
        else:
            if strField:
                strBool = False
                if isinstance(strValue, str):
                    strBool = True
                elif isinstance(strValue, unicode):
                    strBool = True
                else:
                    strStrValue = str(strValue)

                if strBool:
                    strValueP = self.getApostropheStr(strValue)
                    str2 = " WHERE " + strField + oper + "\"" + strValueP + "\""
                else:
                    str2 = " WHERE " + strField + oper + strStrValue

            if strValue2:
                strBool = False
                if isinstance(strValue2, str):
                    strBool = True
                elif isinstance(strValue2, unicode):
                    strBool = True
                else:
                    strStrValue2 = str(strValue2)
                if strBool:
                    strValue2P = self.getApostropheStr(strValue2)
                    str2 += " AND \"" + strValue2P + "\""
                else:
                    str2 += " AND " + strStrValue2
        cursor = self.conn.cursor()
        sqlStr = str1 + str2
        try:
            cursor.execute(sqlStr)
        except:
            err = 1
            print "getdb: db connect error " + sqlStr
        qList = []
        if not err:
            while (1):
                row = cursor.fetchone()
                if not row:
                    break
                if retLen == 1:
                    row2 = row[0]
                else:
                    row2 = row[:]
                qList.append(row2)
        cursor.close()
        return qList

    def getApostropheStr(self, inStr):
        try:
            qInd = inStr.index("'")
        except:
            qInd = -1
        if qInd > -1:
            pLen = len(inStr)
            outStr = inStr[0:qInd] + "\\" + inStr[qInd:pLen]
        else:
            outStr = inStr           
        return outStr
     

    def getOperatorSymbol(self, op):
        oper = "="
        if op == GREATER_THAN:
            oper = ">"
        elif op == GREATER_THAN_OR_EQUAL_TO:
            oper = ">="
        elif op == LESS_THAN:
            oper = "<"
        elif op == LESS_THAN_OR_EQUAL_TO:
            oper = "<="
        elif op == NOT_EQUAL_TO:
            oper = "<>"
        elif op == BETWEEN:
            oper = " BETWEEN "
        return oper


    def update(self, strFieldTup, valTup, condStr="", condVal=0):
        err = 0
        str1 = "UPDATE " + self.table + " SET "
        str2 = ""
        str2a = ""
        i = 0
        if isinstance(valTup, tuple):
            for strField in strFieldTup:
                if not strField:
                    break
                strBool = False
                if isinstance(valTup[i], str):
                    strBool = True
                elif isinstance(valTup[i], unicode):
                    strBool = True
                else:
                    strValue = str(valTup[i])
                if strBool:
                    valItemStr = self.getApostropheStr(valTup[i])
                    str2 = str2 + strField + "=" + "\"" + valItemStr + "\"" + ", "
                else:
                    str2 = str2 + strField + "=" + strValue + ", "            
                i = i + 1
            strLen = len(str2)
            if strLen > 1:
                strLen = strLen - 2
            str2a = str2[0:strLen] + " "
        else:
            if isinstance(valTup, str):
                valTup2 = self.getApostropheStr(valTup)
                str2 = strFieldTup + "=" + "\"" + valTup2 + "\""
            elif isinstance(valTup, unicode):
                valTup2 = self.getApostropheStr(valTup)
                str2 = strFieldTup + "=" + "\"" + valTup2 + "\""
            else:
                str2 = strFieldTup + "=" + str(valTup)
            str2a = str2
        str3 = ""
        if condStr:
            strBool = False
            if isinstance(condVal, str):
                strBool = True
            elif isinstance(condVal, unicode):
                strBool = True
            else:
                strValue = str(condVal)
            if strBool:
                str3 = " WHERE " + condStr + "=" + "\"" + condVal + "\""
            else:
                str3 = " WHERE " + condStr + "= " + strValue            
        cursor = self.conn.cursor()
        sqlStr = str1 + str2a + str3
        err = 0
        try:
            cursor.execute(sqlStr)
        except:
            err = 1
        cursor.close()
        if err:
            print "Database Update Error " + sqlStr
        else:
            self.conn.commit()
            print "update db: " + sqlStr
        return err        
                                            
    def executeSql(self, sqlStr, commit=0):
        cursor = self.conn.cursor()
        err = 0
        try:
            cursor.execute(sqlStr)
        except Exception, e:
            err = 1
            print "Database Write Error" + e
            print sqlStr
        if commit and not err:
            self.conn.commit()
        cursor.close()
        return err    

    def callBetTransaction(self, procargs, acct_id=0):        
        cursor = self.conn.cursor()
        err = 0
        retval = 0
        procname = "handle_transaction8"
        sqlStr = ""
        try:
            cursor.callproc(procname, procargs)
        except Exception, e:
            err = 1
            print "Database call proc error " + e
            print procname
        if not err:
            rettup = cursor.fetchone()
            if rettup:
                retval = int(rettup[0])
                self.conn.commit()
            cursor.close()
            if acct_id:
                retval = self.getLatestTransid(acct_id)
        return retval

    def callDepTransaction(self, procargs, acct_id=0):
        cursor = self.conn.cursor()
        err = 0
        retval = 0
        procname = "handle_transaction_dep"
        try:
            cursor.callproc(procname, procargs)
        except Exception, e:
            err = 1
            print "Database call proc error " + e
            print procname
        if not err:
            rettup = cursor.fetchone()
            if rettup:
                retval = int(rettup[0])
                self.conn.commit()
            cursor.close()
            if acct_id:
                retval = self.getLatestTransid(acct_id,0)
        return retval

    def getLatestTransid(self, acct_id=0, bet=1):
        trans_id = 0
        if bet:
            a_str = "from"
        else:
            a_str = "to"
        if acct_id:
            cur2 = self.conn.cursor()
            sqlStr = "SELECT trans_id FROM transaction WHERE " + a_str + "_acct_id=" + str(acct_id) + " ORDER BY trans_id DESC LIMIT 1"            
            cur2.execute(sqlStr)
            rettup = cur2.fetchone()
            if rettup:
                trans_id = int(rettup[0])
            cur2.close()
        return trans_id

    def close(self):
        err = 0
        try:
            self.conn.close()
        except:
            err = 1
        self.conn = None