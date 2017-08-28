import re
import time
import datetime
import sys
import os
from random import randrange as rr
from random import shuffle

# function_type or php_function
CONVERT_ODDS = 1
FORMAT_ODDS = 2
SESS_DISPLAY_ODDS = 3
POST_FORMAT = 4

in_dir = "d://webServer//py//stage//"
out_dir = "d://webServer//"

keyword_list = ["if", "else", "{", "}", "require", "session_start", "<?php", "?>"]

begDollarsPat = re.compile(r'(.*)\$(.*) = (.*);(.*)')
convertOddsPat = re.compile(r'(.*)convertOdds\((.*)\);(.*)')
formatOddsPat = re.compile(r'(.*)formatOdds\((.*)\);(.*)')
displayOddsPat = re.compile(r'(.*)SESS_DISPLAY_ODDS(.*)')
postFormatPat = re.compile(r'(.*)postFormat\((.*)\);(.*)')

def day2str(iday):
    return "%02d" % iday
    
def mtf2date(datestr):
    retstr = ""
    if len(datestr) == 8:
        mo = datestr[0:2]
        da = datestr[2:4]
        yr = datestr[4:]
        retstr = yr + '-' + mo + '-' + da
    return retstr

def getTimeDateStr(method=0,justdate=0):
    nw = datetime.datetime.now()
    datstr = str(nw.year)+day2str(nw.month)+day2str(nw.day)
    if not justdate:
        datstr += day2str(nw.hour)+day2str(nw.minute)+day2str(nw.second)  
    return datstr

def postFormat(instr, total_pool, inkey1, inkey2):
    outval1 = ""
    outval2 = ""
    instr2 = instr
    if isinstance(total_pool, int) or isinstance(total_pool, float):
        total_pool2 = int(total_pool)
    else:
        err = 0
        total_pool2a = eval(total_pool)
        try:
            total_pool2 = int(total_pool2a)
        except:
            err = 1
        if err:
            total_pool2 = int(float(total_pool2a))

    if not total_pool2:
        outval1 = "0"
        outval2 = "0"
    else:
        if isinstance(instr2, str):
            if len(instr2) > 1:
                fc = instr2[0]
                rest_str = instr2[1:]
                if fc == '+':
                    outval2 = rest_str
                elif  fc == '-':
                    outval1 = rest_str
    return (inkey1, outval1, inkey2, outval2)
    
def formatOdds(entry_odds1, entry_odds2):
    #format blanks, first char = + means 2nd param was formatted,
    #first char = - means 1st param was formatted.
    #e means no formatting is done.
    len1 = len(entry_odds1)
    len2 = len(entry_odds2)
    fc = '+'
    retstr = ""
    diff = len1 - len2
    debg = 1
    if diff > 0:
        i = 0
        retstr = fc
        dotpos = entry_odds2.find('.')
        if dotpos == 1 and len2 == 3:
            entry_odds2 += "0"
            diff -= 1
        while i < diff:
            retstr += "&nbsp"
            i += 1
        retstr += entry_odds2
        debg = 2
    elif diff < 0:
        diff *= -1
        fc = '-'
        i = 0
        retstr = fc
        dotpos = entry_odds1.find('.')
        if dotpos == 1 and len1 == 3:
            entry_odds1 += "0"
            diff -= 1
        while i < diff:
            retstr += "&nbsp"
            i += 1
        retstr += entry_odds1
        debg = 3
    else:
        fc = 'e'
        debg = 4;
        retstr = fc + entry_odds1
#    print "debug formatOdds: entry_odds1 = %s. entry_odds2 = %s. retstring = %s" % (entry_odds1, entry_odds2, retstr)
    return retstr

def convertOdds(entry_odds, odds_type, other_val):
    odds_type2 = int(eval(odds_type))
    entry_odds2 = float(eval(entry_odds))
    if isinstance(other_val, int) or isinstance(other_val, float):
        other_val2 = float(other_val)
    else:
        other_val2 = float(eval(other_val))    
    other_val3 = other_val2 * 100.0
    entry_odds3 = entry_odds2 * 100.0
    ret_string = ""
# odds_type 0 american, 1 decimal, 2 fraction
    if odds_type2 > 2 or odds_type2 < 0:
        odds_type2 = 0
    debg = 1
    if not odds_type2:
        if not entry_odds2:
            if other_val3 >1000000.0:
                other_val3 /= 100.0
                ret_string = "-" + str(int(round(other_val3,0)))
                debg = 2
            elif other_val3 > 100000.0:
                other_val3 /= 10.0
                ret_string = "-" + str(int(round(other_val3,0)))
                debg = 3
            elif other_val3 > 0.0:
                ret_string = "-" + str(int(round(other_val3,0)))
                debg = 4
            else:
                ret_odds = 0.0
                ret_string = "-0.0"
                debg = 5
        elif entry_odds2 <= 1.0:
            ret_odds = -1.0 / entry_odds2
            ret_string = str(int(round(100 * ret_odds,0)))
            debg = 6
        else:
            if entry_odds3 > 1000000.0:
                entry_odds3 /= 100.0
                ret_string = "+" + str(int(round(entry_odds3,0)))
                debg = 7
            elif entry_odds3 > 100000.0:
                entry_odds3 /= 10.0
                ret_string = "+" + str(int(round(entry_odds3,0)))
                debg = 8
#            elif entry_odds3 == other_val3 and entry_odds3 > 1000:
#                ret_string = "-" + str(int(round(entry_odds3,0)))
#                debg = 12
            else:
                ret_string = "+" + str(int(round(entry_odds3,0)))
                debg = 9
    elif odds_type2 == 2:
        ret_string = "catsbigolevaggy"
        debg = 10
    else:
        ret_string = str(round(entry_odds2,2))
        debg = 11
    if ret_string == '-70000' or ret_string == '+70000':
        print "debug convertOdds: debug = %s. entry_odds = %.2f. odds_type = %s, other_val = %.2f" % (debg, entry_odds2, odds_type2, other_val2)    
    return ret_string
    
def getDateAndTime(start_time):
    # look for ','
    # get game_date
    # use now for now
    now = datetime.datetime.now()
    dattime = ""
    datdat = ""
    afttime = ""
    yrstr = str(now.year)
    mostr = day2str(now.month)
    dastr = day2str(now.day)
    hrstr = day2str(now.hour)
    mnstr = day2str(now.minute)
    sestr = day2str(now.second)
    hr1 = 0
    if start_time:
        retstr = start_time.split(',')
        if len(retstr) == 1:    # no commas, just use input string.
            dattime = start_time
        elif len(retstr) == 2:  # two tings so hours and minutes
            hr1 = int(retstr[0])
            min1 = int(retstr[1])
            hrstr = day2str(hr1)
            mnstr = day2str(min1)
            sestr = '00'
        elif len(retstr) == 3: # day,hr,min
            da1 = int(retstr[0])
            hr1 = int(retstr[1])
            min1 = int(retstr[2])
            dastr = day2str(da1)
            hrstr = day2str(hr1)
            mnstr = day2str(min1)
            sestr = '00'
        elif len(retstr) == 4: # mo,day,hr,min
            mo1 = int(retstr[0])
            da1 = int(retstr[1])
            hr1 = int(retstr[2])
            min1 = int(retstr[3])
            mostr = day2str(mo1)
            dastr = day2str(da1)
            hrstr = day2str(hr1)
            mnstr = day2str(min1)
            sestr = '00'
        elif len(retstr) == 5: # yr,mo,day,hr,min
            yrstr = retstr[0]
            mo1 = int(retstr[1])
            da1 = int(retstr[2])
            hr1 = int(retstr[3])
            min1 = int(retstr[4])
            mostr = day2str(mo1)
            dastr = day2str(da1)
            hrstr = day2str(hr1)
            mnstr = day2str(min1)
            sestr = '00'
    if not dattime:
        dattime = yrstr + '-' + mostr + '-' + dastr + ' ' + hrstr + ':' + mnstr + ':' + sestr
    retstr2 = dattime.split(' ')
    if len(retstr2) > 1:
        datdat = retstr2[0]
    return (dattime, datdat)
    
class FB_Document():
    def __init__(self, in_filename, out_filename, logged_in=True):
        self.in_filename = in_dir + in_filename
        self.basefile = out_filename
        self.out_filename = out_dir + out_filename
        self.logged_in = logged_in
        self.out_line_arr = []
        self.fin = open(self.in_filename,'r')
        self.fout = None
        self.tokenDic = {}
        flist = out_filename.split('.')
        if len(flist) == 2:
            self.fileType = flist[1]
        else:
            self.fileType = "txt"
        for line in self.fin:
            self.out_line_arr.append(FB_Line(line))
        self.fin.close()

    def removePhp(self):
        tempArr = self.out_line_arr[:]
        self.out_line_arr = []
        last_line = FB_Line("")
        for line in tempArr:
            if last_line.php and not last_line.php_end:
                line.php = 1
            if not line.php:
                self.out_line_arr.append(line)
            last_line = line
        
    def makeTokenDic(self):
        for lineObj in self.out_line_arr:
            if lineObj.fb_token:
                val2 = lineObj.fb_token.value
                lindy = val2.find('$')
                if lindy > -1 and  lindy < 3:
                    val3 = self.tokenDic.get(val2)
                    if val3:
                        val2 = val3
                self.tokenDic[lineObj.fb_token.name] = val2
                
    def convertArgsAndRunFunctions(self):
        for lineObj in self.out_line_arr:
            if lineObj.php_function:
                argList2 = []
                i = 0
                for key in lineObj.func_arg_list:
                    val = self.tokenDic.get(key)
                    if lineObj.php_function == POST_FORMAT:
                        if val and i < 2:
                            argList2.append(val)
                        else:
                            argList2.append(key)
                    else:
                        if val:
                            argList2.append(val)
                        else:
                            argList2.append(key)
                    i += 1
                retval = lineObj.runFunction(argList2)
                if retval and lineObj.fb_token:
                    lineObj.modifyToken(retval)
                    self.tokenDic[lineObj.fb_token.name] = retval
                elif isinstance(retval, tuple):
                    key1 = retval[0]
                    val1 = retval[1]
                    key2 = retval[2]
                    val2 = retval[3]
                    if val1:
                        self.tokenDic[key1] = val1
#                        print "debug postFormat val1: %s %s %s %s" % retval
                    if val2:
                        self.tokenDic[key2] = val2
#                        print "debug postFormat val2: %s %s %s %s" % retval
#                    if not val1 and not val2:
#                        print "debug postFormat no vals: %s %s %s %s" % retval
                    
    def writeFile(self):
        self.fout = open(self.out_filename,'w')
        for lineObj in self.out_line_arr:
            self.fout.write(lineObj.line_str)
        self.fout.close()    
            
    def convertToHtml(self):
        fourDollarsPat = re.compile(r'(.*)\$(.*)"(.*)\$(.*)"(.*)\$(.*)"(.*)\$(.*)"(.*)')
        threeDollarsPat = re.compile(r'(.*)\$(.*)"(.*)\$(.*)"(.*)\$(.*)"(.*)')
        twoDollarsPat = re.compile(r'(.*)\$(.*)"(.*)\$(.*)"(.*)')
        oneDollarsPat = re.compile(r'(.*)\$(.*)"(.*)')

        tempArr = self.out_line_arr[:]
        self.out_line_arr = []
        if not self.tokenDic:
            createDic = 1
        else:
            createDic = 0
        for lineObj in tempArr:
            outStr = ""
            if lineObj.fb_token:
                if createDic:
                    self.tokenDic[lineObj.fb_token.name] = lineObj.fb_token.value
                continue
            if lineObj.php_builtin:
                continue
            if lineObj.php_echo:
                line_str2 = ""
                mtemp = None
                groupRange = 0
                m4 = fourDollarsPat.match(lineObj.line_str)
                if m4:
                    mtemp = m4
                    groupRange = 4
                else:
                    m3 = threeDollarsPat.match(lineObj.line_str)
                    if m3:
                        mtemp = m3
                        groupRange = 3
                    else: 
                        m2 = twoDollarsPat.match(lineObj.line_str)
                        if m2:                
                            mtemp = m2
                            groupRange = 2
                        else:
                            m1 = oneDollarsPat.match(lineObj.line_str)
                            if m1:                        
                                mtemp = m1
                                groupRange = 1

                if mtemp:
                    j = 0
                    for i in range(groupRange):
                        j = i + 1
                        key1 = self.getPatKey(mtemp.group(2*j))
                        val1 = self.tokenDic.get(key1)
                        if val1:
                            if not line_str2:
                                line_str2 = mtemp.group(0).replace(key1, val1)
                            else:
                                line_str2 = line_str2.replace(key1, val1)
#                    line_str3 = line_str2.replace('.', '')
                    line_str3 = self.periodReplace(line_str2)
                    line_str2 = line_str3
                lineObj.removeEchoAndMakeList(line_str2)
                outStr = ""
                dontDo = 1
                if not dontDo:
                    if lineObj.str_arr:
                        for chunk in lineObj.str_arr:
                            chunk2 = chunk
                            lindy = chunk.find('$')
                            lindy = -1
                            if lindy >= 0 and lindy < 2:
                                val = self.tokenDic.get(chunk.strip())
                                if val:
                                    chunk2 = val
                            outStr += chunk2
                    else:
                        outStr = lineObj.line_str
                else:
                    outStr = lineObj.line_str2
            outStr3 = self.removeCharsAndSemi(outStr, '"')
            self.out_line_arr.append(FB_Line(outStr3))

    def periodReplace(self, in_str):
        last_ch = ''
        out_str = ""
        for ch in in_str:
            err = 0
            try:
                ich = int(last_ch)
            except:
                err = 1
            last_ch = ch
            if ch == '.' and err:
                continue
            out_str += ch            
        return out_str

    def getPatKey(self, patStr):
        lindy = patStr.find('"')
        if lindy > 0 and lindy < 30:
            retstr = '$' + patStr[0:lindy]
        else:
            print "error: bad pat"
            retstr = ""
        return retstr
        
    def removeCharsAndSemi(self, strVal, desChar):
        lindy = strVal.find('\\n')
        if lindy >= 0:
            strVal2 = strVal[0:lindy]
        else:
            strVal2 = strVal
        retval = ""
        for ch in strVal2:
#            if ch == desChar or ch == ';' or ch == '\n':
            if ch == desChar:
                continue
            retval += ch
        retval += '\n'
        return retval       


class FB_Line():
    def __init__(self, lin_str, php=0, mtf=0, commy=0):
        self.line_str = lin_str
        self.line_str2 = ""
        self.str_arr = []
        self.php = php
        self.mtf = mtf
        self.php_start = 0 
        self.php_end = 0
        self.php_builtin = 0
        self.comment = commy
        self.comment_start = 0
        self.comment_end = 0
        self.fb_token = None
        self.php_echo = 0
        self.php_function = 0
        self.func_arg_list = []
        self.game_index = -1
        err = 0
        try:
            self.line_str.index('//')
        except:
            err = 1
        if not err:
            self.comment = 1
        err = 0
        try:
            self.line_str.index('/*')
        except:
            err = 1
        if not err:
            self.comment_start = 1

        err = 0
        try:
            self.line_str.index('*/')
        except:
            err = 1
        if not err:
            self.comment_end = 1
        
        err = 0
        try:
            self.line_str.index('<!--')
        except:
            err = 1
        if not err:
            self.comment_start = 1

        err = 0
        try:
            self.line_str.index('-->')
        except:
            err = 1
        if not err:
            self.comment_end = 1

        err = 0
        lind = 10
        try:
            lind = self.line_str.index('<?php')
        except:
            err = 1
        if not err and lind < 2:
            self.php_start = 1
            self.php = 1
        err = 0
        try:
            self.line_str.index('?>')
        except:
            err = 1
        if not err and not self.comment:
            self.php_end = 1
            self.php = 1
                            
        mf1 = convertOddsPat.match(self.line_str)
        if mf1:
            self.php_function = CONVERT_ODDS
            argList = mf1.group(2).split(',')
            if len(argList) == 3:
                for chunk in argList:
                    self.func_arg_list.append(chunk.strip())
                    
        mf2 = formatOddsPat.match(self.line_str)
        if mf2:
            self.php_function = FORMAT_ODDS
            argList = mf2.group(2).split(',')
            if len(argList) == 2:
                for chunk in argList:
                    self.func_arg_list.append(chunk.strip())

        mf3 = displayOddsPat.match(self.line_str)
        if mf3:
            self.php_function = SESS_DISPLAY_ODDS

        mf4 = postFormatPat.match(self.line_str)
        if mf4:
            self.php_function = POST_FORMAT
            argList = mf4.group(2).split(',')
            argListLen = len(argList)
            if argListLen == 4:
                for chunk in argList:
                    chunk2 = chunk.strip().replace('&', "")
                    self.func_arg_list.append(chunk2)

        m1 = begDollarsPat.match(self.line_str)
        if m1:
            key = '$' + m1.group(2)
            value = m1.group(3)
            value2 = self.stripDoubleQuotations(value)
            self.fb_token = FB_Token("", key, value2)
            print "fbtoken match"
        else:
#            print "fbtoken no match"
            key = ""
            value = ""        

        err = 0
        lind = 10
        try:
            lind = self.line_str.index('echo "') 
        except:
            err = 1
        if not err and not lind:
            self.php_echo = 1
            
        for keyword in keyword_list:
            lindy = self.line_str.find(keyword)
            if lindy >=0 and lindy < 2:
                self.php_builtin = 1
                break
                
    def modifyToken(self, newval):
        newval2 = self.stripDoubleQuotations(newval)    
        if self.fb_token:
            self.fb_token.value = newval2

    def removeCharsAndSemi(self, strVal, desChar):
        lindy = strVal.find('\\n')
        if lindy >= 0:
            strVal2 = strVal[0:lindy]
        else:
            strVal2 = strVal
        retval = ""
        for ch in strVal2:
#            if ch == desChar or ch == ';' or ch == '\n':
            if ch == desChar:
                continue
            retval += ch
        retval += '\n'
        return retval       

    def stripDoubleQuotations(self, value):
        retval = value
        if isinstance(value, str):
            value2 = value.strip()
            strlen = len(value2)
            if strlen > 4:
                endInd = strlen - 2
                if value2[0] == "'" or value2[0] == '"':
                    if value2[1] == "'" or value2[1] == '"':
                        retval = value2[2:endInd]
        return retval


    def removeEchoAndMakeList(self, tempstr2=""):
        if tempstr2:
            tempStr = tempstr2
        else:
            tempStr = self.line_str.strip()
        lindy = tempStr.find('echo ')
        if not lindy:
            self.line_str2 = tempStr[5:]
        else:
            self.line_str2 = tempStr
        tempArr = self.line_str2.split('.')
        self.str_arr = []
        for chunk in tempArr:
            chunk2 = chunk.strip()
            self.str_arr.append(self.removeCharsAndSemi(chunk2, '"'))

    def runFunction(self, argList=[]):
        retval = None
        if argList:
            argList2 = argList
        else:
            argList2 = self.func_arg_list
        if self.php_function == CONVERT_ODDS and len(argList2) == 3:
            retval = convertOdds(argList2[0], argList2[1], argList2[2])
        elif self.php_function == FORMAT_ODDS and len(argList2) == 2:
            retval = formatOdds(argList2[0], argList2[1])
        elif self.php_function == SESS_DISPLAY_ODDS:
            retval = "0"
        elif self.php_function == POST_FORMAT and len(argList2) == 4:
            retval = postFormat(argList2[0], argList2[1], argList2[2], argList2[3])
        return retval   

class FB_Token():
    def __init__(self, instr, name="", value=""):
        self.name = name
        self.value = value
        if not self.name:
            l1 = instr.split('=')
            if len(l1) == 2:
                name1 = l1[0].strip()
                value1 = l1[1].strip()
                err = 0
                londy = -1
                try:
                    londy = value1.index(';')
                except:
                    err = 1
                strChar = None
                if not err and londy > -1 and londy < (len(value1)-1):
                    strChar = value1[londy+1]
                if strChar:
                    value2 = self.removeCharsAndSemi(value1, strChar)
                    self.value = self.shaveApostrophes(value2)
                    self.name = name1 
                elif not err:
                    self.value = self.shaveApostrophes(value1[0:londy])
                    self.name = name1
            
    def removeCharsAndSemi(self, strVal, desChar):
        retval = ""
        for ch in strVal:
            if ch == desChar or ch == ';' or ch == '\n':
                continue
            retval += ch
        return retval

    def shaveApostrophes(self, strVal):
        retstr = strVal
        endind = -1
        if isinstance(strVal, str):
            endind = len(strVal)
            begChar = strVal[0]
            endChar = strVal[endind-1]
            if begChar == endChar and (begChar == '"' or begChar == "'"):
                retstr = strVal[1:endind-1]
        return retstr

def convertGetUserToHtml(infile, outfile):
    fbDoc = FB_Document(infile, outfile)
    tokenDic = {}
    fbDoc.makeTokenDic()
    fbDoc.convertArgsAndRunFunctions()
    fbDoc.convertToHtml()
    fbDoc.writeFile()    

if __name__ == '__main__':
    if len(sys.argv) == 2:
        outfile = sys.argv[1]
        infile = "index.php"
    else:
#        infile = "index.php"
#        outfile = "index.html"
        infile = "get_user6.php"
        outfile = "test_user6.html"

#    fbDoc = FB_Document(infile, outfile)
#    fbDoc.removePhp()
#    fbDoc.writeFile()
    convertGetUserToHtml(infile, outfile)
