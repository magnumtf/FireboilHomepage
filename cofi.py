import os
import os.path
import shutil
import sys
from ftplib import FTP
skipArr = ['jpg','png']

def coFiles(destDrive, ipadd1="2"):
    inDir = os.getcwd()
    inDir += "\\"
    ip_address = "10.0.0." + ipadd1
    ftp = None
    if not destDrive:
        outDir = "D:\\webServer\\"
    elif destDrive == 'ftp':
        outDir = 'STOR '
        ftp = FTP(ip_address, 'mtf', 'farttt')
    else:
        ind = inDir.find(":")
        if ind > 0:
            outDir = destDrive[0] + ":\\" + inDir[ind+1:]
        else:
            outDir = "d:\\work\\"
    maniFile = inDir + "manifest.txt"
    fin = open(maniFile,'r')
    for line in fin:
        if len(line) >= 2:
            if line[0] == '/' and line[1] == '/':
                print "comment line-skip"
                continue
        elif len(line) < 2:
            continue
        srcFile = inDir + line
        destFile = outDir + line
        inds = srcFile.find('\n')
        indd = destFile.find('\n')
        if inds > 0:
            srcFile2 = srcFile[:inds]
        else:
            srcFile2 = srcFile
        if indd > 0:
            destFile2 = destFile[:indd]
        else:
            destFile2 = destFile
        err = 0
        if ftp:
            err2 = 0
            lind = -1
            ltup = line.split('.')
            if len(ltup) > 1:
                try:
                    lind = skipArr.index(ltup[1][:3])
                except:
                    err = 1
                if lind < 0:
                    err = 0
                    try:
                        fp = open(srcFile2)
                    except:
                        err2 = 1
                    if not err2:
                        ftp.storlines(destFile2, fp)
                        fp.close()
                else:
                    err = 1
            else:
                err = 2
            if not err and err2:
                err = 3
        else:
            try:
                shutil.copy2(srcFile2, destFile2)
            except:
                err = 1
        if err:
            print "Error, file %s to %s not copied. err = %s" % (srcFile2, destFile2, err)
        else:
            print "copy %s to %s" % (srcFile2, destFile2)
    fin.close()
    if ftp:
        err4 = 0
        try:
            ftp.quit()
        except:
            err4 = 1

if __name__ == '__main__':
    if len(sys.argv) >= 3: 
        destDrive = sys.argv[1]
        ipadd1 = sys.argv[2]
    elif len(sys.argv) >= 2: 
        destDrive = sys.argv[1]
        ipadd1 = "2"
    else:
        destDrive = ""
        ipadd1 = "2"
    coFiles(destDrive, ipadd1)
