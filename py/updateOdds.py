import time
import MySQLdb
import sys
import random
import db_rap2
import game
from random import randrange
import os
import shutil
 
generateBovFile = 1
gu2_file_p = "gu_@_2.php"
gu6_file_p = "gu_@_6.php"
gu2_bov_file_p = "gu_@_2_bov.php"
dest_dir = "d://webServer//"
stage_dir = "d://webServer//py//stage//"

fb_php_files_a = [gu2_file_p, gu6_file_p, gu2_bov_file_p]
fb_php_files = []
# nfl, etc for each page.
page_types = ["top5"]

def makePhpFile(instr, pageType):
    l1 = instr.split('@')
    outstr = ""
    if len(l1) == 2:
        outstr = l1[0] + pageType + l1[1]
    return outstr

def writeGetUserHeader(fout):
    fout.write("<?php\n") 
    fout.write("session_start();\n")
    fout.write("require 'odd_funcs.php';\n")

class Page:
    def __init__(self,name,status,conn=None):
        self.status = status
        self.name = name
        self.conn = conn
        self.bov_compare = 0
        self.pick6 = 0
        self.pick2 = 0
        self.file2_names = []
        self.file6_names = []
        self.filebov_names = []
        self.file2_names_copy = []
        self.file6_names_copy = []
        self.filebov_names_copy = []
        self.file2_fileptr = []
        self.file6_fileptr = []
        self.filebov_fileptr = []
        self.game_arr = []
        if not self.conn:
            self.connect()
        if self.conn:
            self.game_arr = self.getGameArr()
        description = "This shape has not been described yet"
        author = "Nobody has claimed to make this shape yet"

    def connect(self):
        err = 0
        if not self.conn:
            try:
                self.conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
            except:
                err = 1
            if err:
                self.conn = None
            if self.conn:
                self.setConnection()
            
    def setConnection(self, conn=None):
        if conn:
            self.conn = conn
        if self.conn:
            for gam in self.game_arr:
                gam.setConnection(self.conn)

    def close(self):
        if self.conn:
            self.conn.close()
            self.conn = None
        for gam in self.game_arr:
            gam.close()
            
    def makeFileArrays(self):
        if self.pick2:
            fname2 = makePhpFile(gu2_file_p, self.name)
            self.file2_names.append(stage_dir + fname2)
            self.file2_names_copy.append(dest_dir + fname2)
        if self.pick6:
            fname2 = makePhpFile(gu6_file_p, self.name)
            self.file6_names.append(stage_dir + fname2)
            self.file6_names_copy.append(dest_dir + fname2)
        if self.bov_compare:
            fname2 = makePhpFile(gu2_bov_file_p, self.name)
            self.filebov_names.append(stage_dir + fname2)
            self.filebov_names_copy.append(dest_dir + fname2)
        
    def copyFilesToDest(self):
        self.copyFiles2(self.file2_names,self.file2_names_copy)
        self.copyFiles2(self.file6_names,self.file6_names_copy)
        self.copyFiles2(self.filebov_names,self.filebov_names_copy)
    
    def copyFiles2(self, get_file_arr, dest_file_arr):
        if len(get_file_arr) < 1:
            print "copy file error, no data"
        elif len(get_file_arr) != len(dest_file_arr):
            print "copy file data error"
        else:
            i = 0
            for gfile in get_file_arr:
                dfile = dest_file_arr[i]
                err = 0
                try:
                    shutil.copyfile(gfile, dfile)
                except:
                    err = 1
                if err:
                    print "shutil.copyfile error!"
                i += 1
    
    def makeFilePtrArrays(self):
        self.file2_fileptr = []
        self.file6_fileptr = []
        self.filebov_fileptr = []
        err = 0
        if self.file2_names:
            for filename in self.file2_names:
                try:
                    tempp = open(filename, 'w')
                except:
                    err = 1
                if err:
                    break
                self.file2_fileptr.append(tempp)
        if self.file6_names and not err:
            for filename in self.file6_names:
                try:
                    tempp = open(filename, 'w')
                except:
                    err = 1
                if err:
                    break
                self.file6_fileptr.append(tempp)
        if self.filebov_names and not err:
            for filename in self.filebov_names:
                try:
                    tempp = open(filename, 'w')
                except:
                    err = 1
                if err:
                    break            
                self.filebov_fileptr.append(tempp)
        if err:
            print "open file error on file %s" % filename
        return err
    def closeFiles(self):
        for filep in self.file2_fileptr:
            filep.close()
        for filep in self.file6_fileptr:
            filep.close()
        for filep in self.filebov_fileptr:
            filep.close()
        file2_fileptr = []
        file6_fileptr = []
        filebov_fileptr = []
        
    def getGameArr(self):
        ret_arr = []
        if not self.conn:
            self.connect()
        if self.conn:
            tab3 = db_rap2.dbTable("game_disp", self.conn)
            rettup = tab3.get("game_desc_id","status",self.status)  #status == 2 is top5 page.  Top5 page has 5 or 6 games and 1 meta game associated with it.
                                                                    # game_desc_id_arr
                                                                    #  so a page has a name (top5), a status number (2)
                                                                    #  filep_2_arr - just one, filep_6_arr 1 or 2, and a filep_2_bov_arr just 1.
            for tup in rettup:
                ret_arr.append(game.Game(tup, self.conn))
        return ret_arr
    
    def testFileWrite(self):
        if self.file2_fileptr:
            filep  = self.file2_fileptr[0]
            for i in range(10):
                filep.write("""catsbigvag """ + str(i) + """\n""")
        else:
            print "yo null file2_fileptr"
    
    def writeGUFilesHeader(self):
        if self.file2_fileptr:
            for filep in self.file2_fileptr:
                writeGetUserHeader(filep)
                if self.game_arr:
                    self.game_arr[0].writeGameDayHeaderTable(filep)

        if self.filebov_fileptr:
            for filep in self.filebov_fileptr:
                writeGetUserHeader(filep)
                if self.game_arr:
                    self.game_arr[0].writeGameDayHeaderTable(filep)
                    
        if self.file6_fileptr:
            for filep in self.file6_fileptr:
                writeGetUserHeader(filep)
    
    def updateOdds(self):
        for gam in self.game_arr:
            gam.updateOdds()

    def writeGUFilesData(self):
        jk = 0
        for gam in self.game_arr:
            jk += 1
            if gam.num_metas == 6 and len(gam.game_arr) == 6 and len(gam.pool_arr) == 1 and self.pick6:
                if self.file6_fileptr:
                    for filep in self.file6_fileptr:
                        gam.writeGetUserGameOdds6(filep)
                        gam.writeGetUserEnder6(filep)

            elif gam.num_metas < 6 and self.pick2:
                if self.file2_fileptr:
                    for filep in self.file2_fileptr:
                        gam.writeGetUserGameOdds(filep, jk)
                        gam.writeGetUserEnder(filep, jk)
            if gam.num_metas < 6 and self.bov_compare:
                if self.filebov_fileptr:
                    for filep in self.filebov_fileptr:
                        gam.writeGetUserGameOdds(filep, jk)
                        gam.writeGetUserCompareOdds(filep, "Bovada", jk)
                        gam.writeGetUserEnder(filep, jk, 1)
                        gam.writeGetUserEnderCompare(filep,"Bovada", jk)

    def writeGUFilesFooter(self):
        if self.file2_fileptr:
            for filep in self.file2_fileptr:
                if self.game_arr:
                    self.game_arr[0].writeGameDayFooter(filep)

        if self.filebov_fileptr:
            for filep in self.filebov_fileptr:
                if self.game_arr:
                    self.game_arr[0].writeGameDayFooter(filep)

        if self.file6_fileptr:
            for filep in self.file6_fileptr:
                filep.write("?>\n")

def main(out_period=2,max_loops=1000, test=0):        
    out_period *= 2
    conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")

    homepage = Page("top5", 2, conn)
    homepage.bov_compare = 1
    for gam in homepage.game_arr:
        if gam.num_metas == 6 and not homepage.pick6:
            homepage.pick6 = 1
        elif gam.num_metas != 6:
            homepage.pick2 = 1  
    homepage.makeFileArrays()
    
    print "start update Odds"
    j = 0
    for i in range(max_loops):
        writeFiles = 0
        # mtf to do, use page array
        page1 = homepage
        
        if not page1.conn:
            # mtf to do, connect all pages
            j += 1
            conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
            page1.setConnection(conn)            
            print "update %s. new connection!" % j

        if not (i % out_period):
            writeFiles = 1
            page1.closeFiles()
            err = page1.makeFilePtrArrays()
            if err:
                print "open file error!"
            page1.writeGUFilesHeader()

        page1.updateOdds()
        if writeFiles:
            page1.writeGUFilesData()
            page1.close()
            page1.writeGUFilesFooter()
            page1.closeFiles()
        elif i > 10:
            page1.copyFilesToDest()
                    	
        time.sleep(0.5)

if __name__ == '__main__':
    test = 0
    if len(sys.argv) > 2:
        loops = int(sys.argv[1])
        output_rate = int(sys.argv[2])
    elif len(sys.argv) > 1:
        loops = int(sys.argv[1])
        output_rate = 2
    else:
        loops = 1000
        output_rate = 2
    main(output_rate,loops,test)
