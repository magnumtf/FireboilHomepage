import MySQLdb
import re
import time
import datetime
import db_rap2
from db_rap2 import dbTable as dbTab
from random import randrange as rr
from random import shuffle
from itertools import product as iterproduct

#g1 = game.Game(0,conn,"St. Louis at Detroit","9,13,00",rot_id_names,1,1,0,1,1) #cat,subcat,hometeam,create,num_metas
# yo mtf, accounts work, now fix pools and test game_desc gets

sub_cat_NONE = 0
sub_cat_NFL = 1
sub_cat_MLB = 2
sub_cat_NBA = 3
sub_cat_NCAA = 4
sub_cat_OLYMPICS = 5

p_type_SPREAD = 1
p_type_MONEYLINE = 2
p_type_PWP = 3
p_type_OVER_UNDER = 4
p_type_TEAM_OVER_UNDER = 5
p_type_MULTI_ENTRY = 6
p_type_META_GAME = 7

p_stat_SETUP = 1
p_stat_PRE_GAME = 2
p_stat_LIMITING = 3
p_stat_GAME_STARTED = 4
p_stat_GAME_OVER = 5
p_stat_RESULTS_IN = 6
p_stat_CLOSED =	7	

MAX_ENTRIES = 6

MAX_ODDS_3 = 20
MAX_ODDS_10 = 200
MAX_ODDS_100 = 1000
MIN_ODDS = 0.01

RAND_ARR_LEN = 50
PICK6_BLOCK_SIZE = 5

daysOfWeekDic = { "Sun":"Sunday", "Mon":"Monday", "Tue":"Tuesday", "Wed":"Wednesday", "Thu":"Thursday", "Fri":"Friday", "Sat":"Saturday" }
monthsOfYearDic = { "Jan":"January", "Feb":"February", "Mar":"March", "Apr":"April", "May":"May", "Jun":"June", "Jul":"July", "Aug":"August", "Sep":"September", "Oct":"October", "Nov":"November", "Dec":"December" }
# general enums
OVER = 1
UNDER = 2
PUSH = 3

TIMEZONE = "EDT"

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
    
def getDateAndTime(start_time):
    # look for ','
    # get game_date
    # use now for now
    now = datetime.datetime.now()
    dattime = ""
    dattime2 = ""
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
        dattime2 = dastr + '_' + mostr2 + '_' + yrstr
    retstr2 = dattime.split(' ')
    if len(retstr2) > 1:
        datdat = retstr2[0]
    return (dattime, datdat)
        
class Game():
    def __init__(self, game_desc_id, conn=None, game_name="", start_time="", rot_id_arr=[], category=[], subcategory=[], hometeam=0, create=0, num_metas=0):
        self.game_desc_id = game_desc_id
        self.conn = conn
        self.table = dbTab("game_desc",self.conn)
        self.game_name = game_name
        if start_time:
            rtup = getDateAndTime(start_time)
        else:
            rtup = ("","")
        self.start_time = rtup[0]
        self.game_date = rtup[1]
        self.game_time = self.getGameTime(self.start_time)
        rtupgd = self.getGameDayHeader()
        self.game_name2 = rtupgd[0]
        self.game_date2 = rtupgd[1]
        self.rot_id_arr = rot_id_arr
        self.entry_names = []
        self.entry_venues = []
        self.game_venue = ""
        self.category = category
        self.subcategory = subcategory
        self.status = 1
        self.hometeam = hometeam
        self.num_metas = num_metas
        self.pool_type_arr = []
        self.pool_arr = []
        self.game_arr = []
        self.rot_id_base = 0
        rtup = ()
        if create and self.rot_id_arr:
            if self.num_metas == 6 and len(self.rot_id_arr) == 6:
                self.setGameBasedParameters()
                self.game_arr = self.getGameArray(self.rot_id_arr)
                entry_arr = self.rot_id_arr
                num_entries = len(self.rot_id_arr)
            else:
                self.setGameBasedParameters()
                entry_arr = []
                self.rot_id_arr = self.getRotIDArray(rot_id_arr)
                num_entries = len(self.rot_id_arr)
                for i in range(MAX_ENTRIES):
                    if i < len(self.rot_id_arr):
                        entry_arr.append(self.rot_id_arr[i])
                    else:
                        entry_arr.append(0)
                if not hometeam:
                    self.hometeam = entry_arr[1]
            self.game_desc_id = self.table.put(("name","start_time","num_entries","category","subcategory","entry1","entry2","entry3","entry4","entry5","entry6","hometeam","status","num_metas"),(self.game_name,self.start_time,num_entries,self.category,self.subcategory,entry_arr[0],entry_arr[1],entry_arr[2],entry_arr[3],entry_arr[4],entry_arr[5],self.hometeam,1,self.num_metas))
            self.createGamePools()
            if self.num_metas < 6:
                rettup = self.getEntryNames()
                self.entry_names = rettup[0]
                self.entry_venues = rettup[1]
                rind = -1
                err = 0
                try:
                    rind = self.rot_id_arr.index(self.hometeam)
                except:
                    err = 1
                if rind > -1 and rind < len(self.entry_venues):
                    self.game_venue = self.entry_venues[rind]
            elif self.num_metas == 6 and len(self.game_arr) == 6 and len(self.pool_arr) == 1:
                self.pool_arr[0].getEntryNames6(self.game_date)
        elif self.game_desc_id:
            rtup = self.table.get(("game_desc_id","name","start_time","num_entries","category","subcategory","entry1","entry2","entry3","entry4","entry5","entry6","hometeam","status","num_metas"),"game_desc_id",self.game_desc_id)
        elif game_name and self.start_time:
            rtup = self.table.get(("game_desc_id","name","start_time","num_entries","category","subcategory","entry1","entry2","entry3","entry4","entry5","entry6","hometeam","status","num_metas"),("name","start_time"),(self.game_name,self.start_time))
          
        if rtup:
            self.game_desc_id = rtup[0][0]
            self.game_name = rtup[0][1]
            self.start_time = str(rtup[0][2])
            retstr1 = self.start_time.split(' ')
            self.game_date = retstr1[0]
            self.game_time = self.getGameTime(self.start_time)
            rtupgd = self.getGameDayHeader()
            self.game_name2 = rtupgd[0]
            self.game_date2 = rtupgd[1]
            self.category = rtup[0][4]
            self.subcategory = rtup[0][5]
            self.hometeam = rtup[0][12]
            self.rot_id_arr = []
            for i in range(MAX_ENTRIES):
                if i >= rtup[0][3]:
                    break
                self.rot_id_arr.append(rtup[0][6+i])
            self.status = rtup[0][13]
            self.num_metas = rtup[0][14]
            self.pool_type_arr = []
            self.pool_arr = []
            if self.num_metas == 6:
                self.game_arr = self.getGameArray(self.rot_id_arr)
                self.getGamePools()
                self.pool_arr[0].getEntryNames6(self.game_date)
            else:
                self.getGamePools()
                rettup = self.getEntryNames()
                self.entry_names = rettup[0]
                self.entry_venues = rettup[1]
                rind = -1
                err = 0
                try:
                    rind = self.rot_id_arr.index(self.hometeam)
                except:
                    err = 1
                if rind > -1 and rind < len(self.entry_venues):
                    self.game_venue = self.entry_venues[rind]

    def setGameArray(self, g_arr):
        self.game_arr = g_arr
    
    def getGameArray(self, rot_id_arr):
        ret_arr = []
        for rot_id in rot_id_arr:
            err = 0
            try:
                gam = Game(rot_id, self.conn)
            except:
                err = 1
            if not err:
                if not gam.rot_id_arr:
                    err = 1
            if err:
                ret_arr = []
                break
            ret_arr.append(gam)
        return ret_arr
        
    def connect(self):
        if not self.conn:
            conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
            self.setConnection(conn)
                        
    def getRotIDArray(self, rotid_arr):
        err = 0
        ename_id_arr2 = []
        rotid_arr2 = []
        oldTableName = self.table.table
        self.table.table = "entry_name"
        for e_name in rotid_arr:
            rotid_temp = self.table.get("entry_name_id", ("fullname","category","subcategory"), (e_name,self.category,self.subcategory))
            if not rotid_temp:
                rotid_temp = self.table.get("entry_name_id", ("name","category","subcategory"), (e_name,self.category,self.subcategory))
                if not rotid_temp:
                    rotid_temp = self.table.get("entry_name_id", ("abbrev","category","subcategory"), (e_name,self.category,self.subcategory))
                    if not rotid_temp:
                        err = 1
                        break
            ename_id_arr2.append(rotid_temp[0])
        self.table.table = "entry"
        if not err:
            for enid in ename_id_arr2:
                rotid_temp = self.table.get("rot_id", ("entry_name_id", "gamedate"), (enid, self.game_date))
                rotid_temp2 = self.table.getJoin("entry.rot_id", ("entry.gamedate","entry_name.category","entry_name.subcategory"), (self.game_date,self.category,self.subcategory),"entry_name","entry_name_id")
                if len(rotid_temp2) > 0:
                    lastrotid = rotid_temp2[-1]
                else:
                    lastrotid = self.rot_id_base
                nextrotid = lastrotid + 1
                if not rotid_temp:
                    rotid_temp = self.table.put(("entry_name_id","rot_id","gamedate"), (enid, nextrotid, self.game_date))
                    if not rotid_temp:
                        err = 1
                        break
                    rotid_arr2.append(nextrotid)
                else:
                    rotid_arr2.append(rotid_temp[0])
        if err:
            rotid_arr2 = []
        self.table.table = oldTableName
        return rotid_arr2

    def setGameBasedParameters(self):
        if self.category == 1 and self.num_metas <= 1:
            if self.subcategory == sub_cat_NFL:
                self.rot_id_base = 100
            elif self.subcategory == sub_cat_NCAA:
                self.rot_id_base = 200
            else:
                self.rot_id_base = 150
            self.pool_type_arr = [p_type_SPREAD,p_type_MONEYLINE,p_type_PWP,p_type_OVER_UNDER]    # for fooseball cre
        elif self.num_metas == 6:
            self.pool_type_arr = [p_type_META_GAME]


    def getGamePools(self):
        oldTableName = self.table.table
        self.pool_arr = []
        self.pool_type_arr = []
        self.table.table = "pool"
        rettup = self.table.get(("pool_id","type"),"game_desc_id",self.game_desc_id)
        for tup in rettup:
            self.pool_type_arr.append(tup[1])
            pol = Pool(tup[0],self.conn,0,self.game_desc_id)
            if not pol.entry_arr1:
                pol.entry_arr1 = self.getPoolEntryArr(self.rot_id_arr, tup[1])
                for rot in pol.entry_arr1:
                    pol.entryObj_arr1.append(Entry(rot))
            pol.getBovOdds()
            self.pool_arr.append(pol)
        self.table.table = oldTableName
        if self.num_metas == 6 and len(self.game_arr) == 6 and len(self.pool_arr) == 1:
            j = 0
            self.pool_arr[0].spread_arr = []
            self.pool_arr[0].favorite_arr = []
            for gam in self.game_arr:
                j += 1
                rot_id_arr2 = gam.rot_id_arr[:]
                if len(gam.rot_id_arr) == 2:
                    rot_id_arr2.append(PUSH)                
                self.pool_arr[0].addEntryArr(j, rot_id_arr2)
                err = 0
                try:
                    pwp_spread = gam.pool_arr[p_type_PWP-1].spread
                    pwp_fav = gam.pool_arr[p_type_PWP-1].spread_favorite
                except:
                    err = 1
                if err:
                    pwp_spread = 69.0
                    pwp_fav = 169
                self.pool_arr[0].spread_arr.append(pwp_spread)
                self.pool_arr[0].favorite_arr.append(pwp_fav)

    def createGamePools(self):
        self.pool_arr = []
        for pt in self.pool_type_arr:
            self.pool_arr.append(self.addGamePool(pt))
        if self.num_metas == 6 and len(self.game_arr) == 6 and len(self.pool_arr) == 1:
            self.pool_arr[0].spread_arr = []
            self.pool_arr[0].favorite_arr = []
            j = 0
            for gam in self.game_arr:
                j += 1
                rot_id_arr2 = gam.rot_id_arr[:]
                if len(gam.rot_id_arr) == 2:
                    rot_id_arr2.append(PUSH)                
                self.pool_arr[0].addEntryArr(j, rot_id_arr2)
                err = 0
                try:
                    pwp_spread = gam.pool_arr[p_type_PWP-1].spread
                    pwp_fav = gam.pool_arr[p_type_PWP-1].spread_favorite
                except:
                    err = 1
                if err:
                    pwp_spread = 69.0
                    pwp_fav = 169
                self.pool_arr[0].spread_arr.append(pwp_spread)
                self.pool_arr[0].favorite_arr.append(pwp_fav)
                
    def getPoolEntryArr(self, rot_id_arr, ptype):
        ret_arr = rot_id_arr[:]
        if ptype == p_type_PWP and len(rot_id_arr) == 2:
            ret_arr.append(PUSH)
        elif ptype == p_type_OVER_UNDER:
            ret_arr = [OVER,UNDER]
        return ret_arr

    def addGamePool(self, pool_type):
        create_date2 = getTimeDateStr()
        oldTableName = self.table.table
        self.table.table = "account"
        account_id = self.table.put(("create_date","balance","status","type"), (create_date2,0.0,1,2))
        rot_id_arr2 = self.getPoolEntryArr(self.rot_id_arr, pool_type)
        p1 = Pool(0,self.conn,account_id,self.game_desc_id,pool_type,0.0,rot_id_arr2,self.num_metas,0,1)
        self.table.table = oldTableName
        return p1

    def getPWPSpread(self, spread, spread_fav, initial_fav, pool_fav):
        retsprd = spread
        retfav = spread_fav
        if spread == 0.0:
            if spread_fav:
                retfav = spread_fav
                retsprd = 1.0
            elif init_fav:
                retfav = init_fav
                retsprd = 1.0
            elif self.hometeam:
                retfav = self.hometeam
                retsprd = 1.0
            elif pool_fav:
                retfav = pool_fav
                retsprd = 1.0
            elif len(self.rot_id_arr) > 1:
                retfav = self.rot_id_arr[1]
                retsprd = 1.0
            else:
                retfav = 0
                retsprd = 1.0            
        elif spread % 1:
            retfav = spread_fav
            roundval = round(spread)
            intval = int(spread)
            if not intval % 2:    # isEven?
                closestOddVal = roundval
                closestEvenVal = intval
            else:
                closestOddVal = intval
                closestEvenVal = roundval
            if intval == 4 or intval == 5:
                retsprd = closestEvenVal
            elif intval < 9:
                retsprd = closestOddVal
            else:
                retsprd = closestEvenVal
        return (retsprd, retfav)

    def getOtherTeam(self, fabteam):
        if len(self.rot_id_arr) > 1:
            oteam = self.rot_id_arr[1]
        else:
            oteam = 0
        for rot in self.rot_id_arr:
            if rot == fabteam:
                break
            oteam = rot
        return oteam

    def updateFBFavorite(self):
        # this should be done on every odds update
        for poo in self.pool_arr:
            poo.updateFavorite()

    def updateFBSpread(self, spread, overunder, fav3=None):
        # this should be done on setup and during the week if the line changes.
        self.updateFBFavorite()
        fav = 0
        spred = spread
        if fav3 != None:
            if fav3 < len(self.rot_id_arr):
                fav = self.rot_id_arr[fav3]
            else:
                fav = fav3
            if spread < 0:
                spred = -spread
            else:
                spred = spread
        elif spread >= 0 and self.hometeam > 0:  # set spread and favorite=hometeam
            fav = self.hometeam
        elif spread >= 0 and len(self.rot_id_arr) > 1:                      # set spread and favorite=entry_arr[1]  #usually hometeam
            fav = self.rot_id_arr[1]
        elif self.hometeam:                # set -spread and favorite=otherteam
            spred = -spread
            fav = self.getOtherTeam(self.hometeam)
        else:                                  # set -spread and favorite=entry_arr[0]
            spred = -spread
            fav = self.rot_id_arr[0]

        for poo in self.pool_arr:
            if poo.type == p_type_SPREAD:
                fav2 = fav
                spred2 = spred
            elif poo.type == p_type_MONEYLINE:
                fav2 = 0
                spred2 = 0.0
            elif poo.type == p_type_PWP:
                rtup = self.getPWPSpread(spred, fav, poo.initial_favorite, poo.favorite)
                fav2 = rtup[1]
                spred2 = rtup[0]
            elif poo.type == p_type_OVER_UNDER:
                fav2 = 0
                spred2 = overunder
            else:
                fav2 = fav
                spred2 = spred            
            poo.updateSpread(spred2,fav2)  #update spread, spread_fav, init_fav in da pool.

    def americanToDecimal(self, odds):
        dec_odds = odds / 100.0
        if dec_odds < 0:
            dec_odds2 = -1.0 / dec_odds
        else:
            dec_odds2 = dec_odds
        return dec_odds2

    def updateBovSpread(self, spread, spread_odds, overunder, overunder_odds, moneyline_odds, fav3=0, mlfav=0):
        # this should be done on setup and during the week if the line changes.
        # given a spread of 3, and a favorite update odds.  if the odds are an array, assume they are in order, else they 
        # are the same.
        # figure out overlay in update odds.
        # nope,  you have to  put in everything, yep yep.
        # pool will need some more tings - probably. rot might need some tings, lets see.
        # odds are probably american, but test if they are decimal.
        # spread has to be set and positive, no array but fav should be filled in!!!!
        # for now this handles bovada and 2 entry games. this will have to be enhanced later to handle multi-entry
        # events (hr).

        spread_odds_arr = []
        if isinstance(spread_odds, list):
            spread_odds_arr = spread_odds
        else:
            for i in range(len(self.rot_id_arr)):
                spread_odds_arr.append(spread_odds)

        overunder_odds_arr = []
        if isinstance(overunder_odds, list):
            overunder_odds_arr = overunder_odds
        else:
            for i in range(2):
                overunder_odds_arr.append(overunder_odds)

        moneyline_odds_arr = []
        if isinstance(moneyline_odds, list):
            moneyline_odds_arr = moneyline_odds
        else:
            for i in range(self.rot_id_arr):
                moneyline_odds_arr.append(moneyline_odds)

        if spread_odds_arr[0] > 0.0 and spread_odds_arr[0] < 9.9:
            oddsType = 1
        else:
            oddsType = 0

        for poo in self.pool_arr:
            if poo.type == p_type_SPREAD or poo.type == p_type_PWP:
                j = 0
                if fav3 < len(self.rot_id_arr):
                    fav4 = self.rot_id_arr[fav3]
                else:
                    fav4 = fav3
                for rot_id in poo.entry_arr1:
                    if rot_id == PUSH:
                        break
                    if not spread_odds_arr[j]:
                        spr_odds = 0.9091
                    elif not oddsType:
                        spr_odds = self.americanToDecimal(spread_odds_arr[j])
                    else:
                        spr_odds = spread_odds_arr[j]
                    
                    poo.setBovOdds(rot_id, spr_odds)
                    if fav4 == rot_id:
                        poo.setBovFavorite(rot_id, 1)
                        poo.setBovSpread(rot_id, -spread)
                        poo.updateBovSpread(-spread, spr_odds, j)
                    else:
                        poo.setBovFavorite(rot_id, 0)
                        poo.setBovSpread(rot_id, spread)
                        poo.updateBovSpread(spread, spr_odds, j)
                    j += 1  
            elif poo.type == p_type_OVER_UNDER:
                j = 0
                for rot_id in poo.entry_arr1:
                    if not overunder_odds_arr[j]:
                        ou_odds = 0.9091
                    elif not oddsType:
                        ou_odds = self.americanToDecimal(overunder_odds_arr[j])
                    else:
                        ou_odds = overunder_odds_arr[j]                    
                    poo.setBovOdds(rot_id, ou_odds)
                    poo.setBovFavorite(rot_id, 0)
                    poo.setBovSpread(rot_id, overunder)
                    poo.updateBovSpread(overunder, ou_odds, j)
                    j += 1
            elif poo.type == p_type_MONEYLINE:
                j = 0
                if mlfav < len(self.rot_id_arr):
                    fav4 = self.rot_id_arr[mlfav]
                else:
                    fav4 = mlfav
                for rot_id in poo.entry_arr1:
                    if not moneyline_odds_arr[j]:
                        ml_odds = 0.9091
                    elif not oddsType:
                        ml_odds = self.americanToDecimal(moneyline_odds_arr[j])
                    else:
                        ml_odds = moneyline_odds_arr[j]
                    
                    poo.setBovOdds(rot_id, ml_odds)
                    if fav4 == rot_id:
                        poo.setBovFavorite(rot_id, 1)
                        poo.setBovSpread(rot_id, 0)
                    else:
                        poo.setBovFavorite(rot_id, 0)
                        poo.setBovSpread(rot_id, 0)
                    poo.updateBovSpread(0, ml_odds, j)
                    j += 1  

    def setStatus(self, strStat):
        if isinstance(strStat, int):
            desStat = strStat
        elif strStat == "start" or strStat == "pregame" or strStat == "pre game":
            desStat = p_stat_PRE_GAME
        elif strStat == "gamestart" or strStat == "game start" or strStat == "window closed" or strStat == "windowclosed":
            desStat = p_stat_GAME_STARTED
        elif strStat == "game over" or strStat == "gameover":
            desStat = p_stat_GAME_OVER
        elif strStat == "closed":
            desStat = p_stat_CLOSED
        else:
            desStat = 1

        oldTableName = self.table.table
        self.table.table = "game_desc"
        self.table.update("status",desStat,"game_desc_id", self.game_desc_id)
        for pool in self.pool_arr:
            p.setStatus(desStat)
        self.table.table = oldTableName

    def updateOdds(self):
        self.connect()
        for poo in self.pool_arr:
            poo.updateOdds()
        self.conn = None

    def getEntryNames(self):
        oldTableName = self.table.table
        self.table.table = "entry"
        ret_arr = []
        ret_arr2 = []
        for rotty in self.rot_id_arr:
            rettup = self.table.getJoin(("entry_name.fullname","entry_name.venue", "entry_name.city"),("entry.rot_id","entry.gamedate"),(rotty,self.game_date),"entry_name","entry_name_id")
            if rettup:
                ret_arr.append(rettup[0][0])
                tempstr = rettup[0][1] + ', ' + rettup[0][2]
                ret_arr2.append(tempstr)
        self.table.table = oldTableName
        if len(ret_arr) == len(self.rot_id_arr):
            for poo in self.pool_arr:
                i = 0
                for rotter in self.rot_id_arr:
                    poo.setEntryName(rotter, ret_arr[i])
                    i += 1
        return (ret_arr,ret_arr2)

    def writeGetUserCompareOdds(self, fout, compareSite, gameNum=0):
        fout.write('$compareName_' + str(gameNum) + ' = "' + compareSite + '";\n')
        for poo in self.pool_arr:
            poo.writeGetUserCompareOdds(fout, compareSite, gameNum)

    def writeGetUserGameOdds(self,fout, gameNum=0):        
        fout.write('$gamename_' + str(gameNum) + ' = "' + self.game_time + ', ' + self.game_venue + '";\n')
        fout.write('$gamename_' + str(gameNum) + '_p = ' + 'str_replace(" ", "_", "' + self.game_time + ', ' + self.game_venue + '");\n')
        fout.write('$gameNum = "' + str(gameNum) + '";\n')
        fout.write('$game_desc_id_' + str(gameNum) + ' = "' + str(self.game_desc_id) + '";\n')
        fout.write('$total_games++;\n')
        i = 0
        gamename_ename_str = "";
        for rot in self.rot_id_arr:
            ename = self.entry_names[i]
            gamename_ename_str += ename
            if not i:
                gamename_ename_str += ' at '
            i += 1
            fout.write('$entry' + str(i) + '_rot_' + str(gameNum) + ' = "' + str(rot) + '";\n')
            fout.write('$entry' + str(i) + '_name_' + str(gameNum) + ' = "' + ename + '";\n')
            fout.write('$entry' + str(i) + '_name_' + str(gameNum) + '_p = ' + 'str_replace(" ", "_", "' + ename + '");\n')
        if len(self.rot_id_arr) == 2:
            fout.write('$entry3_rot_' + str(gameNum) + ' = "' + '3' + '";\n')
            fout.write('$entry1_rot_' + str(gameNum) + '_ou = "' + '1' + '";\n')
            fout.write('$entry2_rot_' + str(gameNum) + '_ou = "' + '2' + '";\n')
        fout.write('$gamename2_' + str(gameNum) + ' = "' + gamename_ename_str + '";\n')
        fout.write('$gamename2_' + str(gameNum) + '_p = ' + 'str_replace(" ", "_", "' + gamename_ename_str + '");\n')
        fout.write('$gamedate2_' + str(gameNum) + ' = "' + self.game_date2 + '";\n')
        fout.write('$num_entries_' + str(gameNum) + ' = "' + str(i) + '";\n')
        for poo in self.pool_arr:
            poo.writeGetUserGameOdds(fout, gameNum)
            
    def writeGetUserGameOdds6(self,fout):
        fout.write('$gamename = "' + self.game_name + '";\n')
        for poo in self.pool_arr:
            poo.writeGetUserGameOdds6(fout)

    def writeGameDayHeaderTable(self, fout, comp_odds=0):
        fout.write('$gamedate = "' + self.game_name2 + '";\n') 
        fout.write('if(!isset($_SESSION["SESS_MEMBER_ID"]) || (trim($_SESSION["SESS_MEMBER_ID"]) == ""))\n') 
        fout.write('{\n')
        fout.write('$colspan_gameday = "7";\n')
        fout.write('$colspan_header = "4";\n')
        fout.write('$betheader_id = "olPercent2_nd";\n')
        fout.write('$betheadergame_id = "betBoxHeaderHeader_nd";\n')
        fout.write('$bets_disabled = "DISABLED";\n')
        fout.write('}\n')
        fout.write('else\n')
        fout.write('{\n')
        fout.write('$colspan_gameday = "8";\n')
        fout.write('$colspan_header = "5";\n')
        fout.write('$betheader_id = "olPercent2";\n')
        fout.write('$betheadergame_id = "betBoxHeaderHeader";\n')
        fout.write('$bets_disabled = "";\n')
        fout.write('}\n')

        fout.write("""echo "<table class='tabley'>\\n";\n""")
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th colspan=" . "$colspan_gameday" . "; id='gameDate'>" . "$gamedate" . "</th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th id='rotHeader'>Rot</th>\\n";\n""")
        fout.write("""echo "<th id='teamNameHeader'>Team</th>\\n";\n""")
        fout.write("""echo "<th id='pointSpreadHeader'>Point Spread</th>\\n";\n""")
        fout.write("""echo "<th id='pointSpreadHeader'>PWP</th>\\n";\n""")
        fout.write("""echo "<th id='pointSpreadHeader'>Moneyline</th>\\n";\n""")
        fout.write("""echo "<th id='ouHeaderLeftHeader'></th>\\n";\n""")
        fout.write("""echo "<th id='ouHeaderRightHeader'>Total</th>\\n";\n""")
        fout.write("""echo "<th id=" . "$betheadergame_id" . ">Amount</th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        fout.write("""echo "</table>\\n";\n""")
        fout.write("""echo "<br />\\n";\n""")
        
        fout.write('if(isset($_COOKIE["ppkDisplayOdds"]))\n') 
        fout.write('{\n')
        if comp_odds:
            fout.write('$odds_type = 3 + intval($_COOKIE["ppkDisplayOdds"]);\n')
        else:
            fout.write('$odds_type = intval($_COOKIE["ppkDisplayOdds"]);\n')

        fout.write('}\n')
        fout.write('else\n')
        fout.write('{\n')
        if comp_odds:
            fout.write('$odds_type = 3;\n')
        else:
            fout.write('$odds_type = 0;\n')
        fout.write('}\n')
        fout.write('$total_games = 0;\n')
        fout.write("""echo "<form name='bform' action='bet-exec2.php' onsubmit='return validateBetForm(" . $_SESSION['SESS_BALANCE'] . ")' method='post' class='f-wrap-100'>\\n";\n""")
        
    def writeGameDayFooter(self, fout):
        fout.write("""echo "<input type='hidden' name='total_games' id='total_games' value=" . "$total_games" . " />\\n";\n""")
        fout.write("""echo "<input type='submit' value='Continue' class='f-submit' />\\n";\n""")
        fout.write("""echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='button' value='Reset' id='resetform' class='f-submit' onClick='resetForm()' /><br />\\n";\n""")
        fout.write("""echo "</form>\\n";\n""")
        fout.write("?>\n")

    def writeGetUserEnder(self,fout, gameNum=0, skipBr=0):
        fout.write("""echo "<div id='pool_view'>\\n";\n""")

        fout.write("""echo "<table class='tabley'>\\n";\n""")
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th colspan='3'; id='gameName'>" . "$gamename_""" + str(gameNum) + """" . "</th>\\n";\n""")
        fout.write("""echo "<th colspan=" . "$colspan_header" . "; id='gameDate'><strong>Fireboil Current Odds</strong></th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th id='rot'></th>\\n";\n""")
        fout.write("""echo "<th id='teamName'><input type='hidden' name='gamename_arr[]' value=" . "$gamename_""" + str(gameNum) + """_p" . " /><input type='hidden' name='gamename2_arr[]' value=" . "$gamename2_""" + str(gameNum) + """_p" . " /></th>\\n";\n""")
        fout.write("""echo "<th id='pointSpread'><input type='hidden' name='entry1_name_arr[]' value=" . "$entry1_name_""" + str(gameNum) + """_p" . " /><input type='hidden' name='entry2_name_arr[]' value=" . "$entry2_name_""" + str(gameNum) + """_p" . " /></th>\\n";\n""")
        fout.write("""echo "<th id='pointSpread'><input type='hidden' name='gamedate_arr[]' value=" . "$gamedate" . " /></th>\\n";\n""")
        fout.write("""echo "<th id='pointSpread'></th>\\n";\n""")
        fout.write("""echo "<th id='ouHeaderLeft'></th>\\n";\n""")
        fout.write("""echo "<th id='ouHeaderRight'></th>\\n";\n""")
        fout.write("""echo "<th id='betBoxHeader_nd'></th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        
        fout.write("""echo "<tr>\\n";\n""")
        for poo in self.pool_arr:
            poo.writeGetUserEnder(fout, gameNum)

        fout.write("""echo "<td>" . "$entry1_rot_""" + str(gameNum) + """" . "<input type='hidden' name='game_desc_id_arr[]' id='game_desc_id' value=" . "$game_desc_id_""" + str(gameNum) + """" . " /><input type='hidden' name='rot_id_e1_game""" + str(gameNum) + """' id='rot_id_e1_game""" + str(gameNum) + """' value=" . "$entry1_rot_""" + str(gameNum) + """" . " /><input type='hidden' name='rot_id_e2_game""" + str(gameNum) + """' id='rot_id_e2_game""" + str(gameNum) + """' value=" . "$entry2_rot_""" + str(gameNum) + """" . " /><input type='hidden' name='rot_id_e3_game""" + str(gameNum) + """' id='rot_id_e3_game""" + str(gameNum) + """' value=" . "$entry3_rot_""" + str(gameNum) + """" . " /></td>\\n";\n""")
        fout.write("""echo "<td id='teamNameData'>" . "$entry1_name_""" + str(gameNum) + """" . "<input type='hidden' name='game_num_arr[]' value='""" + str(gameNum) + """'" . " /><input type='hidden' name='acct_id_sp[]' value=" . "$acct_id_sp_""" + str(gameNum) + """" . " /><input type='hidden' name='acct_id_pwp[]' value=" . "$acct_id_pwp_""" + str(gameNum) + """" . " /><input type='hidden' name='acct_id_ml[]' value=" . "$acct_id_ml_""" + str(gameNum) + """" . " /><input type='hidden' name='acct_id_ou[]' value=" . "$acct_id_ou_""" + str(gameNum) + """" . " /></td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre2'>" . "$point_spread1_sp_""" + str(gameNum) + """" . " " . "$entry1_odds_sp_""" + str(gameNum) + """" . "</label><input type='checkbox' name='spread_game""" + str(gameNum) + """[]' id='cb_sp_e1_g""" + str(gameNum) + """' value=" . "$entry1_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")
#mtf        fout.write("""echo "<td id='odds'><label class='bfd' for='genre2'>" . "$point_spread1_sp_""" + str(gameNum) + """" . " " . sprintf_nbsp("%+10.0f", $entry1_odds_sp_""" + str(gameNum) + """) . "</label><input type='checkbox' name='spread_game1[]' id='testchecks' value='100odds' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")

        fout.write("""echo "<td id='odds'><label class='bfd' for='genre7'>" . "$point_spread1_pwp_""" + str(gameNum) + """" . " " . "$entry1_odds_pwp_""" + str(gameNum) + """" . "</label><input type='checkbox' name='pwp_game""" + str(gameNum) + """[]' id='cb_pwp_e1_g""" + str(gameNum) + """' value=" . "$entry1_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre7'>" . "$point_spread1_pwp_""" + str(gameNum) + """" . " " . sprintf_nbsp("%+10.0f", $entry1_odds_pwp_""" + str(gameNum) + """) . "</label><input type='checkbox' name='pwp_game1[]' value='e1' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")

        fout.write("""echo "<td id='odds'><label class='bfd' for='genre'>" . "$entry1_odds_ml_""" + str(gameNum) + """" . "</label><input type='checkbox' name='ml_game""" + str(gameNum) + """[]' id='cb_ml_e1_g""" + str(gameNum) + """' value=" . "$entry1_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")			
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre'>" . sprintf_nbsp("%+10.0f", $entry1_odds_ml_""" + str(gameNum) + """) . "</label><input type='checkbox' name='ml_game1[]' value='e1' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")			

        fout.write("""echo "<td rowspan='2'; id='overUnderNumber'>" . "$point_spread_ou_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td rowspan='2'; id='overUnder'><label id='overUnderLabel' for='genre3'><span class='bfd'>O</span>" . "$entry1_odds_ou_""" + str(gameNum) + """" . "</label><input type='checkbox' name='overunder_game""" + str(gameNum) + """[]' id='cb_ou_e1_g""" + str(gameNum) + """' value=" . "$entry1_rot_""" + str(gameNum) + "_ou" + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /><br />\\n";\n""")
#        fout.write("""echo "<td rowspan='2'; id='overUnder'><label id='overUnderLabel' for='genre3'><span class='bfd'>O</span>" . sprintf_nbsp("%+10.0f", $entry1_odds_ou_""" + str(gameNum) + """) . "</label><input type='checkbox' name='overunder_game1[]' value='e1' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /><br />\\n";\n""")

        fout.write("""echo "<label id='overUnderLabel' for='genre4'><span class='bfd'>U</span>" . "$entry2_odds_ou_""" + str(gameNum) + """" . "</label><input type='checkbox' name='overunder_game""" + str(gameNum) + """[]' id='cb_ou_e2_g""" + str(gameNum) + """' value=" . "$entry2_rot_""" + str(gameNum) + "_ou" + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")
#        fout.write("""echo "<label id='overUnderLabel' for='genre4'><span class='bfd'>U</span>" . sprintf_nbsp("%+10.0f", $entry2_odds_ou_""" + str(gameNum) + """) . "</label><input type='checkbox' name='overunder_game1[]' value='e2' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")

        fout.write("""echo "<td id=" . "$betheader_id" . "><input name='betbox_e1_game""" + str(gameNum) + """' id='betbox_e1_game""" + str(gameNum) + """' type='text' onclick='turnOffRealTime(myVar)' tabindex='14' /></td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_rot_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='teamNameData'>" . "$entry2_name_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre5'>" . "$point_spread2_sp_""" + str(gameNum) + """" . " " . "$entry2_odds_sp_""" + str(gameNum) + """" . "</label><input type='checkbox' name='spread_game""" + str(gameNum) + """[]' id='cb_sp_e2_g""" + str(gameNum) + """' value=" . "$entry2_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre5'>" . "$point_spread2_sp_""" + str(gameNum) + """" . " " . sprintf_nbsp("%+10.0f", $entry2_odds_sp_""" + str(gameNum) + """) . "</label><input type='checkbox' name='spread_game1[]' value='e2' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")

        fout.write("""echo "<td id='odds'><label class='bfd' for='genre8'>" . "$point_spread2_pwp_""" + str(gameNum) + """" . " " . "$entry2_odds_pwp_""" + str(gameNum) + """" . "</label><input type='checkbox' name='pwp_game""" + str(gameNum) + """[]' id='cb_pwp_e2_g""" + str(gameNum) + """' value=" . "$entry2_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre8'>" . "$point_spread2_pwp_""" + str(gameNum) + """" . " " . sprintf_nbsp("%+10.0f", $entry2_odds_pwp_""" + str(gameNum) + """) . "</label><input type='checkbox' name='pwp_game1[]' value='e2' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . "/></td>\\n";\n""")

        fout.write("""echo "<td id='odds'><label class='bfd' for='genre6'>" . "$entry2_odds_ml_""" + str(gameNum) + """" . "</label><input type='checkbox' name='ml_game""" + str(gameNum) + """[]' id='cb_ml_e2_g""" + str(gameNum) + """' value=" . "$entry2_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")		
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre6'>" . sprintf_nbsp("%+10.0f", $entry2_odds_ml_""" + str(gameNum) + """) . "</label><input type='checkbox' name='ml_game1[]' value='e2' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")		

        fout.write("""echo "<td id=" . "$betheader_id" . "><input name='betbox_e2_game""" + str(gameNum) + """' id='betbox_e2_game""" + str(gameNum) + """' type='text' onclick='turnOffRealTime(myVar)' tabindex='15' /></td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td><input type='hidden' name='point_spread1_sp_""" + str(gameNum) + """' value= " . "$point_spread1_sp_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread2_sp_""" + str(gameNum) + """' value= " . "$point_spread2_sp_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread1_pwp_""" + str(gameNum) + """' value= " . "$point_spread1_pwp_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread2_pwp_""" + str(gameNum) + """' value= " . "$point_spread2_pwp_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread3_pwp_""" + str(gameNum) + """' value= " . "$point_spread3_pwp_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread1_ou_""" + str(gameNum) + """' value= " . "$point_spread1_ou_""" + str(gameNum) + """" . " /><input type='hidden' name='point_spread2_ou_""" + str(gameNum) + """' value= " . "$point_spread2_ou_""" + str(gameNum) + """" . " /></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre9'>" . "Push" . " " . "$entry3_odds_pwp_""" + str(gameNum) + """" . "</label><input type='checkbox' name='pwp_game""" + str(gameNum) + """[]' id='cb_pwp_e3_g""" + str(gameNum) + """' value=" . "$entry3_rot_""" + str(gameNum) + """" . " onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")
#        fout.write("""echo "<td id='odds'><label class='bfd' for='genre9'>" . "Push" . " " . sprintf_nbsp("%+10.0f", $entry3_odds_pwp_""" + str(gameNum) + """) . "</label><input type='checkbox' name='pwp_game1[]' value='e3' onClick='turnOffRealTime(myVar)' " . "$bets_disabled" . " /></td>\\n";\n""")

        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id=" . "$betheader_id" . "><input name='betbox_e3_game""" + str(gameNum) + """' id='betbox_e3_game""" + str(gameNum) + """' type='text' onclick='turnOffRealTime(myVar)' tabindex='16' /></td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        fout.write("""echo "</table>\\n";\n""")

        fout.write("""echo "<input type='hidden' name='entry1_odds_sp_arr[]' value=" . "$entry1_odds_sp_""" + str(gameNum) + """p" . " /><input type='hidden' name='entry2_odds_sp_arr[]' value=" . "$entry2_odds_sp_""" + str(gameNum) + """p" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='entry1_odds_pwp_arr[]' value=" . "$entry1_odds_pwp_""" + str(gameNum) + """p" . " /><input type='hidden' name='entry2_odds_pwp_arr[]' value=" . "$entry2_odds_pwp_""" + str(gameNum) + """p" . " /><input type='hidden' name='entry3_odds_pwp_arr[]' value=" . "$entry3_odds_pwp_""" + str(gameNum) + """p" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='entry1_odds_ml_arr[]' value=" . "$entry1_odds_ml_""" + str(gameNum) + """p" . " /><input type='hidden' name='entry2_odds_ml_arr[]' value=" . "$entry2_odds_ml_""" + str(gameNum) + """p" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='entry1_odds_ou_arr[]' value=" . "$entry1_odds_ou_""" + str(gameNum) + """p" . " /><input type='hidden' name='entry2_odds_ou_arr[]' value=" . "$entry2_odds_ou_""" + str(gameNum) + """p" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='pool_size_sp_game""" + str(gameNum) + """' id='pool_size_sp_game""" + str(gameNum) + """' value=" . "$pool_size_sp_""" + str(gameNum) + """" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='pool_size_pwp_game""" + str(gameNum) + """' id='pool_size_pwp_game""" + str(gameNum) + """' value=" . "$pool_size_pwp_""" + str(gameNum) + """" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='pool_size_ml_game""" + str(gameNum) + """' id='pool_size_ml_game""" + str(gameNum) + """' value=" . "$pool_size_ml_""" + str(gameNum) + """" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='pool_size_ou_game""" + str(gameNum) + """' id='pool_size_ou_game""" + str(gameNum) + """' value=" . "$pool_size_ou_""" + str(gameNum) + """" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='rot_id_e1_game""" + str(gameNum) + """_ou' id='rot_id_e1_game""" + str(gameNum) + """_ou' value=" . "$entry1_rot_""" + str(gameNum) + """_ou" . " /><input type='hidden' name='rot_id_e2_game""" + str(gameNum) + """_ou' id='rot_id_e2_game""" + str(gameNum) + """_ou' value=" . "$entry2_rot_""" + str(gameNum) + """_ou" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='gamedate2_arr[]' value=" . "$gamedate2_""" + str(gameNum) + """" . " />\\n";\n""")
        if not skipBr:
            fout.write("""echo "</div>\\n";\n""")
            fout.write("""echo "<hr />\\n";\n""")

    def writeGetUserEnderCompare(self,fout,compStr="",gameNum=0):
        fout.write("""echo "<table class='tabley'>\\n";\n""")        
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th id='badRot'></th>\\n";\n""")
        fout.write("""echo "<th id='badTeamName'></th>\\n";\n""")
        fout.write("""echo "<th id='badPointSpread'></th>\\n";\n""")
        fout.write("""echo "<th id='overlay_h2'></th>\\n";\n""")
        fout.write("""echo "<th id='badPointSpread_pwp'></th>\\n";\n""")
        fout.write("""echo "<th id='overlay_h2'></th>\\n";\n""")
        fout.write("""echo "<th id='badPointSpread_ml'></th>\\n";\n""")
        fout.write("""echo "<th id='overlay_h2'></th>\\n";\n""")
        fout.write("""echo "<th id='badOuHeaderRight'></th>\\n";\n""")
        fout.write("""echo "<th id='overlay_h2'></th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td colspan='2'>Compare with current odds at: <strong>" . "$compareName_""" + str(gameNum) + """" . "</strong></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id='overlay_data'><strong>Overlay</strong></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id='overlay_data'><strong>Overlay</strong></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id='overlay_data'><strong>Overlay</strong></td>\\n";\n""")
        fout.write("""echo "<td></td>\\n";\n""")
        fout.write("""echo "<td id='overlay_data'><strong>Overlay</strong></td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_rot_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='teamNameData'>" . "$entry1_name_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre2'>" . "$point_spread1_sp_""" + str(gameNum) + """_cmp" . " " . "$entry1_odds_sp_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre2' value='100odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay1_sp_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre2'>" . "$entry1_odds_pwp_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre2' value='104odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay1_pwp_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre2'>" . "$entry1_odds_ml_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre2' value='101odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay1_ml_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td rowspan='2'; id='overUnder'><label id='overUnderLabel' for='genre3'><span class='bfd'>O</span>" . "$entry1_odds_ou_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre3' value='overUnderOdds1' DISABLED /><br />\\n";\n""")
        fout.write("""echo "<label id='overUnderLabel' for='genre4'><span class='bfd'>U</span>" . "$entry2_odds_ou_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre4' value='overUnderOdds2' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay1_ou_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_rot_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='teamNameData'>" . "$entry2_name_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre5'>" . "$point_spread2_sp_""" + str(gameNum) + """_cmp" . " " . "$entry2_odds_sp_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre5' value='102odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay2_sp_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre5'>" . "$entry2_odds_pwp_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre5' value='105odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay2_pwp_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='odds'><label class='bfd' for='genre6'>" . "$entry2_odds_ml_""" + str(gameNum) + """_cmp" . "</label><input type='checkbox' name='genre6' value='100odds' DISABLED /></td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay2_ml_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "<td id='olPercent'>" . "$overlay2_ou_""" + str(gameNum) + """" . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")

        fout.write("""echo "</table>\\n";\n""")
        fout.write("""echo "</div>\\n";\n""")
        fout.write("""echo "<hr />\\n";\n""")

    def writeGetUserEnder6(self,fout):
        fout.write("""echo "<div id='pool_view'>\\n";\n""")
        fout.write("""echo "<table id='hor-minimalist-a' summary='Pick 6 Current Odds'>\\n";\n""")
        fout.write("""echo "<colgroup>\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col />\\n";\n""")
        fout.write("""echo "<col class='oce-first' />\\n";\n""")
        fout.write("""echo "</colgroup>\\n";\n""")

        fout.write("""echo "<thead>\\n";\n""")
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th colspan='7'><span>" . "$gamename" . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Carryover: $" . "$carryover" . "</span></th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game1" . "$point_spread1_game1" . "<br />" . "$entry2_name_game1" . "$point_spread2_game1" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game2" . "$point_spread1_game2" . "<br />" . "$entry2_name_game2" . "$point_spread2_game2" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game3" . "$point_spread1_game3" . "<br />" . "$entry2_name_game3" . "$point_spread2_game3" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game4" . "$point_spread1_game4" . "<br />" . "$entry2_name_game4" . "$point_spread2_game4" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game5" . "$point_spread1_game5" . "<br />" . "$entry2_name_game5" . "$point_spread2_game5" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>" . "$entry1_name_game6" . "$point_spread1_game6" . "<br />" . "$entry2_name_game6" . "$point_spread2_game6" . "</th>\\n";\n""")
        fout.write("""echo "<th scope='col'>Current<br />Odds</th>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        fout.write("""echo "</thead>\\n";\n""")
        fout.write("""echo "<tbody>\\n";\n""")
# block 1
        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry3_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry4_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry5_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry6_pick_game1" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . sprintf_nbsp("%'#10.2f", $odds_game1) . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")        

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry3_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry4_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry5_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry6_pick_game2" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . sprintf_nbsp("%'#10.2f", $odds_game2) . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")        

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry3_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry4_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry5_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry6_pick_game3" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . sprintf_nbsp("%'#10.2f", $odds_game3) . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")        

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry3_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry4_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry5_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry6_pick_game4" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . sprintf_nbsp("%'#10.2f", $odds_game4) . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")        

        fout.write("""echo "<tr>\\n";\n""")
        fout.write("""echo "<td>" . "$entry1_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry2_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry3_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry4_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry5_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . "$entry6_pick_game5" . "</td>\\n";\n""")
        fout.write("""echo "<td>" . sprintf_nbsp("%'#10.2f", $odds_game5) . "</td>\\n";\n""")
        fout.write("""echo "</tr>\\n";\n""")
        
        fout.write("""echo "</tbody>\\n";\n""")        
        fout.write("""echo "</table>\\n";\n""")
        fout.write("""echo "<br />\\n";\n""")
        fout.write("""echo "</div>\\n";\n""")

    def close(self):
        err = 0
        for poo in self.pool_arr:
            poo.close()
        self.table.close()
        try:
            self.conn.close()
        except:
            err = 1
        self.conn = None

    def setConnection(self, conn2):
        self.conn = conn2
        self.table.conn = conn2
        for poo in self.pool_arr:
            poo.setConnection(conn2)
            
    def getGameTime(self, star_tim):
        rind1 = -1
        rind2 = -1
        rind3 = -1
        hr = 0
        min = 0
        retstr = ""
        if star_tim:
            rind2 = star_tim.index(':')
            rind1 = star_tim.index(' ') + 1
            rind3 = star_tim.index(':',rind2+1)
            if isinstance(rind1, tuple):
                print str(rind1) + " is a tuple"
            elif isinstance(rind2, tuple):
                print str(rind2) + " is a tuple"
            elif isinstance(rind3, tuple):
                print str(rind3) + " is a tuple"
            elif rind1 > 0 and rind2 > 0 and rind3 > 0:
                hrstr = star_tim[rind1:rind2]
                hr = int(hrstr)
                minstr = star_tim[rind2+1:rind3]
                if hr > 12:
                    retstr = str(hr-12) + ':' + minstr + ' PM ' + TIMEZONE
                elif hr == 12:
                    retstr = hrstr + ':' + minstr + ' PM ' + TIMEZONE
                else:
                    retstr = hrstr + ':' + minstr + ' AM ' + TIMEZONE
            else:
                print "bad rind ", rind1, rind2, rind3            
        return retstr
        
    def getGameDayHeader(self):
        gd_arr = self.game_date.split('-')
        retstr = ""
        gd2 = ""
        if len(gd_arr) > 2:
            dat = datetime.date(int(gd_arr[0]),int(gd_arr[1]),int(gd_arr[2]))
        else:
            dat = None
        if dat:
            arr1 = dat.ctime().split(' ')
        else:
            arr1 = None
        if arr1:
            err = 0
            try:
                retstr = daysOfWeekDic[arr1[0]]
            except:
                err = 1
            if not err:
                retstr += ', '
                try:
                    retstr += monthsOfYearDic[arr1[1]]
                    if len(arr1[1]) >= 3:
                        gd2 = gd_arr[2] + '_' + arr1[1][0:3] + '_' + gd_arr[0]
                except:
                    err = 1
                if not err:
                    retstr += ' '
                    retstr += gd_arr[2]
                    retstr += ', '
                    retstr += gd_arr[0]
            if err:
                retstr = ""
        return (retstr, gd2)

class Pool():
    def __init__(self, pool_id, conn=None, account_id=0, game_desc_id = 0, pool_type=0, balance=0.0, rot_id_arr=[], num_metas=0, spread=0, create=0):
        self.pool_id = pool_id
        self.account_id = account_id
        self.conn = conn
        self.table = dbTab("pool",self.conn)
        self.type = pool_type
        self.game_desc_id = game_desc_id
        self.entry_arr1 = rot_id_arr
        self.entryObj_arr1 = []
        for rot in self.entry_arr1:
            self.entryObj_arr1.append(Entry(rot))
        self.num_metas = num_metas
        self.balance = balance
        self.spread = spread
        self.favorite = 0
        self.initial_favorite = 0
        self.spread_favorite = 0
        self.status = 0
        self.random_array_ind = RAND_ARR_LEN
        if create:
            create_date = str(datetime.datetime.now())
            ind = create_date.find('.')
            if ind >= 0:
                oldTableName = self.table.table
                self.table.table = "account"
                create_date2 = create_date[0:ind]
                if not self.account_id:
                    self.account_id = self.table.put(("create_date","balance","status","type"), (create_date2,0.0,1,2))
                if self.account_id > 0:
                    self.table.table = "pool"
                    self.pool_id = self.table.put(("account_id","game_desc_id","type","status","spread","spread_favorite","initial_favorite","favorite","update_time"),(self.account_id,self.game_desc_id,self.type,1,self.spread,self.spread_favorite,self.initial_favorite,self.favorite,create_date2))
                    self.status = 1
                    self.balance = 0.0
                self.table.table = oldTableName
        elif self.table.conn and self.account_id:
            rettup = self.table.getJoin(("account.account_id","pool.game_desc_id","pool.type","account.status","account.balance","pool.spread","pool.favorite","pool.initial_favorite","pool.spread_favorite"),"account_id",self.account_id,"account","account_id")
            if rettup:
                self.account_id = rettup[0][0]
                self.game_desc_id = rettup[0][1]
                self.type = rettup[0][2]
                self.status = rettup[0][3]
                self.balance = rettup[0][4]
                self.spread = rettup[0][5]
                self.favorite = rettup[0][6]
                self.initial_favorite = rettup[0][7]
                self.spread_favorite = rettup[0][8]
        elif self.table.conn and self.pool_id:
            rettup = self.table.getJoin(("account.account_id","pool.game_desc_id","pool.type","account.status","account.balance","pool.spread","pool.favorite","pool.initial_favorite","pool.spread_favorite"),"pool_id",self.pool_id,"account","account_id")
            if rettup:
                self.account_id = rettup[0][0]
                self.game_desc_id = rettup[0][1]
                self.type = rettup[0][2]
                self.status = rettup[0][3]
                self.balance = rettup[0][4]
                self.spread = rettup[0][5]
                self.favorite = rettup[0][6]
                self.initial_favorite = rettup[0][7]
                self.spread_favorite = rettup[0][8]
        self.entry_arr2 = []
        self.entry_arr3 = []
        self.entry_arr4 = []
        self.entry_arr5 = []
        self.entry_arr6 = []
        self.entry_arr7 = []
        self.entry_arr8 = []
        self.entry_arr9 = []
        self.entry_names_dic = {}
        self.oddsTupPush0_arr = []
        self.oddsTupPush1_arr = []
        self.oddsTupPush2_arr = []
        self.oddsTupPush3_arr = []
        self.entry_odds_arr_rand = []
        self.spread_arr = []
        self.favorite_arr = []

        if self.type == p_type_META_GAME and not self.num_metas:
            self.num_metas = 6
        self.total_pool_amt = 0.0
        self.entry_pool_amt_dic = {}
        self.entry_odds_dic = {}

    def addEntryArr(self, game_num, rot_arr):
        err = 0
        if game_num == 1:
            self.entry_arr1 = rot_arr
        elif game_num == 2: 
            self.entry_arr2 = rot_arr
        elif game_num == 3: 
            self.entry_arr3 = rot_arr
        elif game_num == 4: 
            self.entry_arr4 = rot_arr
        elif game_num == 5: 
            self.entry_arr5 = rot_arr
        elif game_num == 6: 
            self.entry_arr6 = rot_arr
        elif game_num == 7: 
            self.entry_arr7 = rot_arr
        elif game_num == 8: 
            self.entry_arr8 = rot_arr
        elif game_num == 9: 
            self.entry_arr9 = rot_arr
        else:
            err = 1
        return err

    def setStatus(self, desStat):
        oldTableName = self.table.table
        self.table.table = "pool"
        self.table.update("status",desStat,"pool_id", self.pool_id)
        self.table.table = oldTableName

    def updateOdds(self, oddtup=(), forceupdate=0):
        retlisttup = ()
        oldtablename = self.table.table
        self.table.table = "account"
        rettup = self.table.get("balance","account_id",self.account_id)        
        if rettup:
            self.balance = rettup[0]
        else:
            print "updateOdds Err: Incorrect Balance"
        self.table.table = "transaction"
        total_sum = 0.0
        if oddtup:
            if self.type <= p_type_TEAM_OVER_UNDER:                    
                retlisttup = self.table.getJoin("transaction.amount",("transaction.to_acct_id","bet.pick_entry1"),(self.pool_id,oddtup),"bet","trans_id")
                self.entry_pool_amt_dic[oddtup] = 0.0
                if self.balance:
                    self.entry_odds_dic[oddtup] = self.balance
                elif len(self.entry_arr1) < 4:
                    self.entry_odds_dic[oddtup] = MIN_ODDS
                    #MAX_ODDS_3
                else:
                    self.entry_odds_dic[oddtup] = MIN_ODDS
                    #MAX_ODDS_10

                for tup in retlisttup:
                    self.entry_pool_amt_dic[oddtup] += float(tup)
                    if self.entry_pool_amt_dic[oddtup]:
                        self.entry_odds_dic[oddtup] = (self.balance - self.entry_pool_amt_dic[oddtup]) / self.entry_pool_amt_dic[oddtup]
                        self.calcBovOverlay(oddtup, self.entry_odds_dic[oddtup])
                    elif self.balance:
                        bal2 = self.balance + 1
                        pool2 = 1
                        self.entry_odds_dic[oddtup] = bal2 - pool2
                        self.calcBovOverlay(oddtup, self.entry_odds_dic[oddtup])
                   
            elif self.type == p_type_META_GAME:
                if self.num_metas == 6:
                    combolist1 = list(iterproduct(self.entry_arr1,self.entry_arr2,self.entry_arr3,self.entry_arr4,self.entry_arr5,self.entry_arr6))
#                    for tup in combolist1:
#                        self.entry_pool_amt_dic[tup] = 0.0
#                        self.entry_odds_dic[tup] = self.balance
                    retlisttup = self.table.getJoin("transaction.amount",("transaction.to_acct_id","bet.pick_entry1","bet.pick_entry2","bet.pick_entry3","bet.pick_entry4","bet.pick_entry5","bet.pick_entry6"),(self.pool_id,oddtup[0],oddtup[1],oddtup[2],oddtup[3],oddtup[4],oddtup[5]),"bet","trans_id")
                    self.entry_pool_amt_dic[oddtup] = 0.0
                    if self.balance:
                        self.entry_odds_dic[oddtup] = self.balance
                    else:
                        self.entry_odds_dic[oddtup] = MAX_ODDS_100
                    for tup in retlisttup:
                        self.entry_pool_amt_dic[oddtup] += float(tup)
                        if self.entry_pool_amt_dic[oddtup]:
                            self.entry_odds_dic[oddtup] = (self.balance - self.entry_pool_amt_dic[oddtup]) / self.entry_pool_amt_dic[oddtup]
                        elif self.balance:
                            bal2 = self.balance + 1
                            pool2 = 1
                            self.entry_odds_dic[oddtup] = bal2 - pool2
        else:
            if self.type <= p_type_TEAM_OVER_UNDER:
                for entry in self.entry_arr1:
                    self.entry_pool_amt_dic[entry] = 0.0
                    if self.balance:
                        self.entry_odds_dic[entry] = self.balance
                    elif len(self.entry_arr1) < 4:
                        self.entry_odds_dic[entry] = MIN_ODDS
                        #MAX_ODDS_3
                    else:                        
                        self.entry_odds_dic[entry] = MIN_ODDS
                        #MAX_ODDS_10
                retlisttup = self.table.getJoin(("bet.pick_entry1","transaction.amount"),"transaction.to_acct_id",self.account_id,"bet","trans_id")
                if self.entry_pool_amt_dic:
                    for tup in retlisttup:
                        keytup = tup[0]
                        amt = tup[1]
                        total_sum += amt
                        self.entry_pool_amt_dic[keytup] += amt
                        if self.entry_pool_amt_dic[keytup]:
                            self.entry_odds_dic[keytup] = (self.balance - self.entry_pool_amt_dic[keytup]) / self.entry_pool_amt_dic[keytup]
                            self.calcBovOverlay(keytup, self.entry_odds_dic[keytup])
                        elif self.balance:
                            bal2 = self.balance + 1
                            pool2 = 1
                            self.entry_odds_dic[keytup] = bal2 - pool2
                            self.calcBovOverlay(keytup, self.entry_odds_dic[keytup])
                
                for entry in self.entry_arr1:
                    if self.balance and self.balance == self.entry_odds_dic[entry]:
                        self.calcBovOverlay(entry, self.balance)

            elif self.type == p_type_META_GAME:
                if self.num_metas == 6 and (self.random_array_ind >= RAND_ARR_LEN or forceupdate):
                    combolist1 = list(iterproduct(self.entry_arr1,self.entry_arr2,self.entry_arr3,self.entry_arr4,self.entry_arr5,self.entry_arr6))
                    for tup in combolist1:
                        self.entry_pool_amt_dic[tup] = 0.0
                        if self.balance:
                            self.entry_odds_dic[tup] = self.balance
                        else:
                            self.entry_odds_dic[tup] = MAX_ODDS_100
                        if tup.count(PUSH) == 0:
                            self.oddsTupPush0_arr.append(tup)
                        elif tup.count(PUSH) == 1:
                            self.oddsTupPush1_arr.append(tup)
                        elif tup.count(PUSH) == 2:
                            self.oddsTupPush2_arr.append(tup)
                        elif tup.count(PUSH) == 3:
                            self.oddsTupPush3_arr.append(tup)
                    
                    retlisttup = self.table.getJoin(("bet.pick_entry1","bet.pick_entry2","bet.pick_entry3","bet.pick_entry4","bet.pick_entry5","bet.pick_entry6","transaction.amount"),"transaction.to_acct_id",self.account_id,"bet","trans_id")
                    if self.entry_pool_amt_dic:
                        for tup in retlisttup:
                            keytup = tup[0:6]
                            amt = tup[6]
                            total_sum += amt
                            self.entry_pool_amt_dic[keytup] += amt
                            if self.entry_pool_amt_dic[keytup]:
                                self.entry_odds_dic[keytup] = (self.balance - self.entry_pool_amt_dic[keytup]) / self.entry_pool_amt_dic[keytup]
                            elif self.balance:
                                bal2 = self.balance + 1
                                pool2 = 1
                                self.entry_odds_dic[keytup] = bal2 - pool2
                    self.makeRandomOddsArray(RAND_ARR_LEN)
        self.table.table = oldtablename
        diff = self.balance - total_sum
        if diff > 1.0 or diff < -1.0:
            if self.num_metas != 6 or forceupdate:
                print "updateOdds err: Table (%.2f) and computed sum (%.2f) disagreeance! yo %s" % (self.balance,total_sum,self.num_metas)        

    def setBovOdds(self, rot_id, odds):
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                ent.bov_odds = odds
                break
    
    def setBovSpread(self, rot_id, spread):
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                ent.bov_spread = spread
                break

    def setEntryName(self, rot_id, ename):
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                ent.name = ename
                break

    def getEntryName(self, rot_id):
        retname = ""
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                retname = ent.name
                break
        return retname

    def setBovFavorite(self, rot_id, fav):
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                ent.bov_favorite = fav
                break

    def calcBovOverlay(self, rot_id, fb_odds):
        for ent in self.entryObj_arr1:
            if ent.rot_id == rot_id:
                ent.odds = fb_odds
                if ent.bov_odds:
                    bov_over = (fb_odds * 100) / ent.bov_odds
                    bov_over -= 100
                    if bov_over >= 10000:
                        ent.bov_overlay = int(bov_over) 
                    else:
                        ent.bov_overlay = round(bov_over, 1) 
                break
    
    def getBovOdds(self):
        oldtablename = self.table.table
        self.table.table = "pool"
        rettup = self.table.get(("bov_spread_e1","bov_spread_e2","bov_odds_e1","bov_odds_e2"),"pool_id",self.pool_id)

        if rettup and len(self.entryObj_arr1) > 1:
            self.entryObj_arr1[0].bov_spread = rettup[0][0]
            self.entryObj_arr1[0].bov_odds = rettup[0][2]
            self.entryObj_arr1[1].bov_spread = rettup[0][1]
            self.entryObj_arr1[1].bov_odds = rettup[0][3]

            if self.entryObj_arr1[0].bov_spread < 0:
                self.entryObj_arr1[0].bov_favorite = 1
                self.entryObj_arr1[1].bov_favorite = 0
            elif self.entryObj_arr1[1].bov_spread < 0:
                self.entryObj_arr1[0].bov_favorite = 0
                self.entryObj_arr1[1].bov_favorite = 1
            elif self.entryObj_arr1[0].bov_odds < self.entryObj_arr1[1].bov_odds:
                self.entryObj_arr1[0].bov_favorite = 1
                self.entryObj_arr1[1].bov_favorite = 0
            else:
                self.entryObj_arr1[0].bov_favorite = 0
                self.entryObj_arr1[1].bov_favorite = 1
            rot_id = self.entryObj_arr1[0].rot_id
            fb_odds = self.entry_odds_dic.get(rot_id)
            if fb_odds:
                self.calcBovOverlay(rot_id, fb_odds)
            rot_id = self.entryObj_arr1[1].rot_id
            fb_odds = self.entry_odds_dic.get(rot_id)
            if fb_odds:
                self.calcBovOverlay(rot_id, fb_odds)

        self.table.table = oldtablename

    def makeRandomOddsArray(self, arraylen):
        # for random array make 4 0 and 1 push.
        # for every 10 pushes use 1 single push
        # for every 100 pushes use 1 double push
        # 1. randomize arrays
        self.entry_odds_arr_rand = []
        self.random_array_ind = 0
        temp_arr = range(len(self.oddsTupPush0_arr))
        shuffle(temp_arr)
        oddsTupPush0_ind = temp_arr[:]
        temp_arr = range(len(self.oddsTupPush1_arr))
        shuffle(temp_arr)
        oddsTupPush1_ind = temp_arr[:]
        temp_arr = range(len(self.oddsTupPush2_arr))
        shuffle(temp_arr)
        oddsTupPush2_ind = temp_arr[:]
        temp_arr = range(len(self.oddsTupPush3_arr))
        shuffle(temp_arr)
        oddsTupPush3_ind = temp_arr[:]
        # initialize indexes
        ind0 = 0
        ind1 = 0
        ind2 = 0
        ind3 = 0
        total_ind = 0
        # make random dic, in chunks of 5.
        push_ind = rr(5)
        rick_rand = rr(100)
        if rick_rand < 1:
            ind = oddsTupPush3_ind[ind3]
            ptup = self.oddsTupPush3_arr[ind]
            ind3 += 1
        elif rick_rand < 10:
            ind = oddsTupPush2_ind[ind2]
            ptup = self.oddsTupPush2_arr[ind]
            ind2 += 1
        else:
            ind = oddsTupPush1_ind[ind1]
            ptup = self.oddsTupPush1_arr[ind]
            ind1 += 1

        while total_ind < arraylen:
            for i in range(5):
                if total_ind == push_ind:
                    tup = ptup
                else:
                    ind = oddsTupPush0_ind[ind0]
                    tup = self.oddsTupPush0_arr[ind]
                    ind0 += 1
                self.entry_odds_arr_rand.append(tup)
                total_ind += 1

            push_ind = total_ind + rr(5)
            rick_rand = rr(100)
            if rick_rand < 1:
                ind = oddsTupPush3_ind[ind3]
                ptup = self.oddsTupPush3_arr[ind]
                ind3 += 1
            elif rick_rand < 10:
                ind = oddsTupPush2_ind[ind2]
                ptup = self.oddsTupPush2_arr[ind]
                ind2 += 1
            else:
                ind = oddsTupPush1_ind[ind1]
                ptup = self.oddsTupPush1_arr[ind]
                ind1 += 1

    def getOdds(self, destup=()):
        err = 0
        val = -99.9
        if destup:
            try:
                val = self.entry_odds_dic[destup]
            except:
                err = 1
            if err:
                print "getOdds key error"
        else:
            val = self.entry_odds_dic
        return val

    def printOdds(self, destup=()):
        err = 0
        if destup:
            try:
                val = self.entry_odds_dic[destup]
            except:
                err = 1
            if not err:
                print "Current odds for %s = %.2f" % (str(destup),val)
            else:
                print "Current odds key error"
        else:
            for ke,val in self.entry_odds_dic.items():
                print "Current odds for %s = %.2f" % (str(ke),val)

    def convertTypeToStr(self, typeval):
        if typeval == 1:
            retstr = "sp"
        elif typeval == 2:
            retstr = "ml"
        elif typeval == 3:
            retstr = "pwp"
        elif typeval == 4:
            retstr = "ou"
        else:
            retstr = ""
        return retstr

    def convertRotIDToAbbrevs(self, names_dic, rot_id_arr, game_date):
        oldTableName = self.table.table
        self.table.table = "entry"
        for rotty in rot_id_arr:
            if rotty == PUSH:
                rettup = ["PUSH"]
            else:
                rettup = self.table.getJoin("entry_name.abbrev",("entry.rot_id","entry.gamedate"),(rotty,game_date),"entry_name","entry_name_id")
            names_dic[rotty] = rettup[0]
        self.table.table = oldTableName
    
    def getEntryNames6(self, game_date):
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr1, game_date)
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr2, game_date)
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr3, game_date)
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr4, game_date)
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr5, game_date)
        self.convertRotIDToAbbrevs(self.entry_names_dic, self.entry_arr6, game_date)

    def writeGetUserGameOdds(self, fout, gameNum=0, comp_site=0):
        typestra = self.convertTypeToStr(self.type)
        temp_str = ""
        if gameNum:
            typestr = typestra + '_' + str(gameNum)
        else:
            typestr = typestra
        point_spread3 = '+' + str(self.spread)
        if not self.spread:
            point_spread1 = 'pk'
            point_spread2 = 'pk'
            point_spread3 = '0.0'
        elif self.spread_favorite == self.entry_arr1[0]:
            point_spread2 = '+' + str(self.spread)
            if (self.type == p_type_OVER_UNDER):
                point_spread1 = '+' + str(self.spread)
            elif (self.type == p_type_PWP):
                point_spread1 = '-' + str(self.spread)
                point_spread3 += ","
                temp_str = self.getEntryName(self.entry_arr1[0])
                point_spread3 += temp_str.replace(' ', '_')
            else:
                point_spread1 = '-' + str(self.spread)
        else:
            point_spread1 = '+' + str(self.spread)
            if (self.type == p_type_OVER_UNDER):
                point_spread2 = '+' + str(self.spread)
            elif (self.type == p_type_PWP):
                point_spread2 = '-' + str(self.spread)
                point_spread3 += ","
                temp_str = self.getEntryName(self.entry_arr1[0])
                point_spread3 += temp_str.replace(' ', '_')
            else:
                point_spread2 = '-' + str(self.spread)

        fout.write('$pool_id_' + typestr + ' = "' + str(self.pool_id) + '";\n')
        fout.write('$point_spread1_' + typestr + ' = "' + point_spread1 + '";\n')
        fout.write('$point_spread2_' + typestr + ' = "' + point_spread2 + '";\n')
        if self.type == p_type_PWP:
            fout.write('$point_spread3_' + typestr + ' = "' + point_spread3 + '";\n')
        
        if self.type == p_type_OVER_UNDER:
            point_spread1a = point_spread1[1:]
            fout.write('$point_spread_' + typestr + ' = "' + point_spread1a + '";\n')        
#        fout.write("$odds_type = $_SESSION['SESS_DISPLAY_ODDS'];\n")
        fout.write('$total_pool_' + typestr + ' = "' + str(self.balance) + '";\n')
        fout.write('$acct_id_' + typestr + ' = "' + str(self.account_id) + '";\n')
        fout.write('$pool_size_' + typestr + ' = "' + str(self.balance) + '";\n')
        i = 0
        max_ind = -1
        max_odds = 0.0
        for key in self.entry_arr1:
            i += 1
            fout.write('$entry' + str(i) + '_pool_' + typestr + ' = "' + str(self.entry_pool_amt_dic[key]) + '";\n')
            fout.write('$entry' + str(i) + '_odds_' + typestr + 'p = "' + str(self.entry_odds_dic[key]) + '";\n')
            if self.entry_odds_dic[key] > max_odds:
                max_odds = self.entry_odds_dic[key]
                max_ind = i
        fout.write('$max_odds_' + typestr + ' = "' + str(max_odds) + '";\n')
        i = 0
        for key in self.entry_arr1:
            i += 1
            if i == max_ind and not comp_site:
                fout.write('$entry' + str(i) + '_odds_' + typestr + ' = convertOdds($entry' + str(i) + '_odds_' + typestr + 'p, $odds_type, 0);\n')
            elif not comp_site:
                fout.write('$entry' + str(i) + '_odds_' + typestr + ' = convertOdds($entry' + str(i) + '_odds_' + typestr + 'p, $odds_type, $max_odds_' + typestr + ');\n')
            elif i == max_ind:
                fout.write('$entry' + str(i) + '_odds_' + typestr + ' = convertOdds($entry' + str(i) + '_odds_' + typestr + 'p, 3 + $odds_type, 0);\n')
            else:
                fout.write('$entry' + str(i) + '_odds_' + typestr + ' = convertOdds($entry' + str(i) + '_odds_' + typestr + 'p, 3 + $odds_type, $max_odds_' + typestr + ');\n')
#        if self.type == p_type_PWP:
#            if self.entry_odds_dic[PUSH] < max_odds:
#mtf                fout.write('$entry_odds_ppp = formatOdds($entry1_odds_' + typestr + ', $entry2_odds_' + typestr + ');\n')
#                fout.write('postFormat($entry_odds_ppp, $total_pool_' + typestr + ', &$entry1_odds_' + typestr + ', &$entry2_odds_' + typestr + ');\n')
#                fout.write('$entry_odds_ppp = formatOdds($entry2_odds_' + typestr + ', $entry3_odds_' + typestr + ');\n')
#                fout.write('postFormat($entry_odds_ppp, $total_pool_' + typestr + ', &$entry2_odds_' + typestr + ', &$entry3_odds_' + typestr + ');\n')
#            else:
#                fout.write('$entry_odds_ppp = formatOdds($entry1_odds_' + typestr + ', $entry3_odds_' + typestr + ');\n')
#                fout.write('postFormat($entry_odds_ppp, $total_pool_' + typestr + ', &$entry1_odds_' + typestr + ', &$entry3_odds_' + typestr + ');\n')
#                fout.write('$entry_odds_ppp = formatOdds($entry2_odds_' + typestr + ', $entry3_odds_' + typestr + ');\n')
#                fout.write('postFormat($entry_odds_ppp, &$entry2_odds_' + typestr + ', &$entry3_odds_' + typestr + ');\n')
#        else:
#            fout.write('$entry_odds_ppp = formatOdds($entry1_odds_' + typestr + ', $entry2_odds_' + typestr + ');\n')
#            fout.write('postFormat($entry_odds_ppp, $total_pool_' + typestr + ', &$entry1_odds_' + typestr + ', &$entry2_odds_' + typestr + ');\n')

    def writeGetUserEnder(self, fout, gameNum):
        typestra = self.convertTypeToStr(self.type)
        if gameNum:
            typestr = typestra + '_' + str(gameNum)
        else:
            typestr = typestra
        fout.write("""echo "<input type='hidden' name='pool_id_arr[]' value=" . "$pool_id_""" + typestr + """" . " />\\n";\n""")
        fout.write("""echo "<input type='hidden' name='acct_id_arr[]' value=" . "$acct_id_""" + typestr + """" . " />\\n";\n""")

    def getCompareSpreadTup(self, cSite, ind):
        spread = 999
        odds = 0.0
        favorite = -1
        overlay = -1
        if cSite == "Bovada":
            if ind < len(self.entryObj_arr1):
                ent = self.entryObj_arr1[ind]
                spread = ent.bov_spread
                odds = ent.bov_odds
                favorite = ent.bov_favorite
                overlay = ent.bov_overlay
        return (spread, odds, favorite, overlay)
        
    def writeGetUserCompareOdds(self, fout, compareSite, gameNum=0):
#need to calc these puppies. 
#"$point_spread1_sp_cmp" X
#"$entry1_odds_sp_cmp" X
#"$overlay_sp" x
#"$entry1_odds_pwp_cmp" x
#"$overlay_pwp" x
#"$entry1_odds_ml_cmp" x
#"$overlay_ml" x
#"$point_spread_ou_cmp"  X DONT NEED
#"$entry1_odds_ou_cmp" x
#"$entry2_odds_ou_cmp" x
#"$overlay_ou" x
#olPercent">17.9%
        typestra = self.convertTypeToStr(self.type)
        if gameNum:
            typestr = typestra + '_' + str(gameNum)
        else:
            typestr = typestra
        for ind in range(len(self.entry_arr1)):
            num = ind + 1
            spreadTup = self.getCompareSpreadTup(compareSite, ind)
            spread = spreadTup[0]
            if not spread:
                point_spread_cmp = 'pk'
            elif spread == 999:
                point_spread_cmp = ''
            elif spread > 0:
                point_spread_cmp = '+' + str(spread)
            else:
                point_spread_cmp = str(spread)            
            fout.write('$point_spread' + str(num) + '_' + typestr + '_cmp = "' + point_spread_cmp + '";\n')
 
            odds = spreadTup[1]
            fout.write('$entry' + str(num) + '_odds_' + typestr + '_cmpp = "' + str(odds) + '";\n')
            fout.write('$entry' + str(num) + '_odds_' + typestr + '_cmp = convertOdds($entry' + str(num) + '_odds_' + typestr + '_cmpp, 3 + $odds_type, 0);\n')

            overlay = str(spreadTup[3]) + '%'
            fout.write('$overlay' + str(num) + '_' + typestr + ' = "' + overlay + '";\n')

    def writeGameEntries(self, fout, rot_id_arr, entry_names, game_num):
        i = 0
        for rot in rot_id_arr:
            ename = entry_names[rot]
            i += 1
            if not ename == "PUSH":
                fout.write('$entry' + str(i) + '_rot_game' + str(game_num) + ' = "' + str(rot) + '";\n')
                fout.write('$entry' + str(i) + '_name_game' + str(game_num) + ' = "' + ename + '";\n')

        ind = game_num - 1
        if ind < len(self.spread_arr):
            pwp_spread = self.spread_arr[ind]
        else:
            pwp_spread = 69.0
        if ind < len(self.favorite_arr):
            pwp_fav = self.favorite_arr[ind]
        else:
            pwp_fav = 169
        fout.write('$pwp_spread_game' + str(game_num) + ' = "' + str(pwp_spread) + '";\n')
        fout.write('$pwp_favorite_game' + str(game_num) + ' = "' + str(pwp_fav) + '";\n')
        
        if len(rot_id_arr) > 1:
            if rot_id_arr[0] == pwp_fav:
                strFavorite1 = " -" + str(int(pwp_spread))
                strFavorite2 = ""
            else:
                strFavorite2 = " -" + str(int(pwp_spread))
                strFavorite1 = ""
        else:
            strFavorite2 = "-69"
            strFavorite1 = ""
        fout.write('$point_spread1_game' + str(game_num) + ' = "' + strFavorite1 + '";\n')
        fout.write('$point_spread2_game' + str(game_num) + ' = "' + strFavorite2 + '";\n')
        
    def convertOddsTupToString(self, oddstup):
        abbrev_name = ""
        entryname_arr = []
        for rot in oddstup:
            err = 0
            try:
                abbrev_name = self.entry_names_dic[rot]
            except:
                err = 1
            if err:
                abbrev_name = "CAT"
            entryname_arr.append(abbrev_name)
        try:
            retodds = self.entry_odds_dic[oddstup]
        except:
            err = 1
        if err:
            retodds = 0.0
        if len(entryname_arr) != 6:
            entryname_arr = ["","","","","",""]        
        return (entryname_arr[0],entryname_arr[1],entryname_arr[2],entryname_arr[3],entryname_arr[4],entryname_arr[5],retodds)

    def writeGetUserGameOdds6(self, fout):
        self.writeGameEntries(fout, self.entry_arr1, self.entry_names_dic, 1)
        self.writeGameEntries(fout, self.entry_arr2, self.entry_names_dic, 2)
        self.writeGameEntries(fout, self.entry_arr3, self.entry_names_dic, 3)
        self.writeGameEntries(fout, self.entry_arr4, self.entry_names_dic, 4)
        self.writeGameEntries(fout, self.entry_arr5, self.entry_names_dic, 5)
        self.writeGameEntries(fout, self.entry_arr6, self.entry_names_dic, 6)
        fout.write('$carryover = "' + str(24000.00) + '";\n')        
        fout.write('$total_pool_p6 = "' + str(self.balance) + '";\n')
        j = 0
        startInd = self.random_array_ind
        endInd = startInd + PICK6_BLOCK_SIZE
        if endInd <= len(self.entry_odds_arr_rand):
            entry_odds_arr_rand2 = self.entry_odds_arr_rand[startInd:endInd]
        else:
            entry_odds_arr_rand2 = entry_odds_arr_rand[:]
        for tup in entry_odds_arr_rand2:
            game_num = j + 1
            rettup = self.convertOddsTupToString(tup)
            fout.write('$entry1_pick_game' + str(game_num) + ' = "' + rettup[0] + '";\n')
            fout.write('$entry2_pick_game' + str(game_num) + ' = "' + rettup[1] + '";\n')
            fout.write('$entry3_pick_game' + str(game_num) + ' = "' + rettup[2] + '";\n')
            fout.write('$entry4_pick_game' + str(game_num) + ' = "' + rettup[3] + '";\n')
            fout.write('$entry5_pick_game' + str(game_num) + ' = "' + rettup[4] + '";\n')
            fout.write('$entry6_pick_game' + str(game_num) + ' = "' + rettup[5] + '";\n')
            fout.write('$odds_game' + str(game_num) + ' = "' + str(rettup[6]) + '";\n')
            j += 1
            self.random_array_ind += 1

    def updateFavorite(self):
        max_pool = 0.0
        ret_fav = 0
        for ke, val in self.entry_pool_amt_dic.items():
            if val > max_pool:
                vax_pool = val
                ret_fav = ke
        if ret_fav:
            oldTableName = self.table.table
            self.table.table = "pool"
            self.favorite = ret_fav
            self.table.update("favorite",self.favorite,"pool_id",self.pool_id)
            self.table.table = oldTableName        
            
#update spread, spread_fav, init_fav in da pool.
    def updateSpread(self, spread, fav):
        oldTableName = self.table.table
        self.table.table = "pool"
        if not self.initial_favorite:
            fav2 = fav 
        else:
            fav2 = self.initial_favorite        
        self.table.update(("spread","spread_favorite","initial_favorite"),(spread,fav,fav2),"pool_id",self.pool_id)
        self.spread = spread
        self.spread_favorite = fav
        self.initial_favorite = fav2
        self.table.table = oldTableName        

    def updateBovSpread(self, spread, odds, rot_id_ind):
        oldTableName = self.table.table
        self.table.table = "pool"
        if rot_id_ind == 1:
            self.table.update(("bov_spread_e2","bov_odds_e2"),(spread,odds),"pool_id",self.pool_id)
        else:
            self.table.update(("bov_spread_e1","bov_odds_e1"),(spread,odds),"pool_id",self.pool_id)
        self.table.table = oldTableName        

    def close(self):
        err = 0
        try:
            self.conn.close()
        except:
            err = 1
        self.table.close()
        self.conn = None
        
    def setConnection(self,conn2):
        self.conn = conn2
        self.table.conn = conn2


class Entry():
    def __init__(self, rot_id, fav=0, name="", odds=0.0, spread=0.0, bov_odds=0.0, bov_spread=0.0, fav2=0):
        self.name = name
        self.rot_id = rot_id
        self.odds = odds
        self.spread = spread
        self.bov_odds = bov_odds
        self.bov_spread = bov_spread
        self.favorite = fav
        self.bov_favorite = fav2
        self.bov_overlay = 0.0

def testRotID1(rotid_arr, tabley):
    err = 0
    ename_id_arr2 = []
    tabley.table = "entry_name"
    for e_name in rotid_arr:
        rotid_temp = tabley.get("entry_name_id", ("fullname","category","subcategory"), (e_name,1,1))
        if not rotid_temp:
            rotid_temp = tabley.get("entry_name_id", ("name","category","subcategory"), (e_name,1,1))
            if not rotid_temp:
                rotid_temp = tabley.get("entry_name_id", ("abbrev","category","subcategory"), (e_name,1,1))
                if not rotid_temp:
                    err = 1
                    break      
        ename_id_arr2.append(rotid_temp[0])
    return ename_id_arr2
    
def testRotID2(ename_id_arr2, tabley):
    tabley.table = "entry"
    gamedate = '2012-09-09'
    rotid_arr2 = []
    err = 0
    if not err:
        for enid in ename_id_arr2:
            rotid_temp = tabley.get("rot_id", ("entry_name_id", "gamedate"), (enid, gamedate))
# yoyoyo gamedate...            
            rotid_temp2 = tabley.getJoin("entry.rot_id", ("entry.gamedate","entry_name.category","entry_name.subcategory"), (gamedate,1,1),"entry_name","entry_name_id")
            print "rotid_temp:", rotid_temp
            print "rotid_temp2:", rotid_temp2
            if len(rotid_temp2) > 0:
                lastrotid = rotid_temp2[-1]
            else:
                lastrotid = 100
            nextrotid = lastrotid + 1
            if not rotid_temp:
                print "before tabley put ",enid
                rotid_temp = tabley.put(("entry_name_id","rot_id","gamedate"), (enid, nextrotid, gamedate))
                print "after tabley put ",enid
                if not rotid_temp:
                    err = 1
                    break
# yoyoyo nextrotid ....
                rotid_arr2.append(nextrotid)
            else:
                rotid_arr2.append(rotid_temp[0])
# end yo
    if err:
        rotid_arr2 = []
    return rotid_arr2