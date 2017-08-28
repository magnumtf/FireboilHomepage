import time
import MySQLdb
import sys
import db_rap2
import customer
import game
from customer import Customer
import random
from random import randrange


# constants
avg_betsize = 600.0
std_betsize = 200.0
bet_upperlimit = 10000.0
bet_lowerlimit = 50.0
bet_upperlimit2 = 1000.0
bet_lowerlimit2 = 10.0

spread_giants = 53
ml_ne = 60
#pwp_giants = 48
# ne = 44
#pwp_push = 8
pwp_giants = 41
# ne = 44
pwp_push = 24
over_ou = 51

base_firstname = "Van"
base_lastname = "Wiener"
base_username = "willis"
base_email = "shortsharter"
base_password = "farttt"

OVER = 1
UNDER = 2
PUSH = 3

# me dont know what this is game_rand_arr = [56,44,41,59,48,43,9,53,47]
#pool_account_arr = [24,25,26,27]    # account id's for pools spread,ml,pwp,overunder
game_rot_arr = [101,102]            # 1st one is the favorite
pool_account_arr = [3111,3112,3113,3114]
game_rand_arr = [48,61,41,53]       # favorite,favorite,favorite,over
min_balance = 10000.00

#note to self:
#  make an odds table that python can update in the background.  This is what the fb website should use to update
#  the forms.

#    test_id = con.insert_id() might need this, there is also another 1

def getRandomGBet(avg_b, std_b):
    bs1 = random.gauss(avg_b,std_b)
    if avg_b < 100:
        bet_ll = bet_lowerlimit2
    else:
        bet_ll = bet_lowerlimit
    if bs1 < bet_ll:
        bs1 = bet_ll
    elif bs1 > bet_upperlimit:
        bs1 = bet_upperlimit
    bs2 = round(bs1 / 100.0)
    bs2 *= 100.0
    return str(bs2)


#    test_id = con.insert_id()
# 1. find all status = ACCEPTING or LIMITING tables and update
#    odd_id, pool_id, team1_odds, team2_odds ..., total_pool, team1_pool ...
#    get odd_id and pool_id
#    from pool: use pool_id to find num_entries.  for each entry  for each entry
# update_odds - look for big jumps but this is only for display. the actual is done diff.
#    you could update the game desc - no the game can have multiple pools.
#    a pool has one account and one game_desc, but a game_desc can have multiple pools, now i have to tas.
#    so to update a pools odds - collect all transactions to the pool account, calculate the odds and update them in the odds table.
#        odds table - odd_id pool_id game_desc_id account_id num_entries total_pool  sum_entry1 sum_entry2 ... odds_entry1 odds_entry2  status IDLE, READY, UPDATING, STOP_UPDATING, FINAL, CLOSED
#        transaction   type  DEPOSIT, WITHDRAWAL, b_credit_w, b_credit_cancel, b_debit,
#        make a bet - game_id, pool_id, amount, entries that should be it.
#        so to figure out odds look for transaction / amounts for b_debits and totals and put it in odds table. 
#    meta_game can have one multiple games yep yep yep


def populateCustomerDB():
    conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
    var = 1
    cnt = 0
    customer_arr = []
    # create or get customer array.
    badCusCnt = 0
    for i in range(1000):
        email2 = base_email + str(i) + "@yahoo.com"
        username2 = base_username + str(i)
        password2 = base_password + str(i)
        firstname2 = base_firstname + str(i)
        lastname2 = base_lastname + str(i)
        cuz = Customer(username2,password2,firstname2,lastname2,email2,conn)
        if cuz.account_id > 10:
            customer_arr.append(cuz)
            if cuz.new_customer:
                cuz.makeDeposit(min_balance)
        else:
            badCusCnt += 1
    print "finished build customer_arr. %s bad customers" % badCusCnt
#    conn.close()
    return customer_arr
    
#2 create game array.
#3 for each game, find all pool's associated with that game. add to pool_array.
# game_id, pool_id, pool_type    
# lets make it easy to bet you only need a pool id.
# for now lets do by hand, this can be fancier in the future

def getCustomer(customerArr):
    if customerArr:    
        ind = randrange(len(customerArr))
        cust = customerArr[ind]
    else:
        cust = None
    return cust

def getPoolAccount():
    pool_acct_id = 0
    rot_id = 0
    type = 0
    rr = randrange(100)
    if rr < 40:
        type = 1
    elif rr < 60:
        type = 2
    elif rr < 80:
        type = 3
    else:
        type = 4
        
    ind = type - 1
    pool_acct_id = pool_account_arr[ind]
    cutoff = game_rand_arr[ind]
    rr = randrange(100)
    fav = game_rot_arr[0]
    udog = game_rot_arr[1]

    if type == 4 and rr < cutoff:
        rot_id = OVER
    elif type == 4:
        rot_id = UNDER
    elif rr < cutoff:
        rot_id = fav
    elif rr < 91:
        rot_id = udog
    elif type == 3:
        rot_id = PUSH
    else:
        rot_id = udog
    return (pool_acct_id, rot_id, type)
    
def getGameFromGameArray(retarr, game_id):
    ret_game = None
    for gam in retarr:
        if gam.game_desc_id == game_id:
            ret_game = gam
            break
    return ret_game

def makeGameArrays():
    retarr = []
    retarr2 = []
    retarr3 = []
    skipThis = 1
    conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
    tab3 = db_rap2.dbTable("game_disp", conn)
    rettup = tab3.get("game_desc_id","status",2)
    for tup in rettup:
        gam = game.Game(tup, conn)
        if gam.num_metas == 6:
            retarr2.append(gam)
        else:
            retarr.append(gam)
    if retarr2 and not skipThis:
        p6_gam = retarr2[0]
        if len(p6_gam.rot_id_arr) == 6:
            for gam_desc in p6_gam.rot_id_arr:
                err = 0
                gam2 = self.getGameFromGameArray(retarr, gam_desc)
                if not gam2:
                    try:
                        gam2 = game.Game(gam_desc, conn)
                    except:
                        err = 1
                    if not err:
                        if not gam2.rot_id_arr:
                            err = 1
                if err:
                    retarr3 = []
                    break
                retarr3.append(gam2)
    conn.close()
    return (retarr, retarr2, retarr3)
    
def getGame(gameArr):
    retgame = None
    if len(gameArr) > 0:
        ind = randrange(len(gameArr))
        retgame = gameArr[ind]
    return retgame
    
def getPoolAccount2(gam):
    pool_acct_id = 0
    rot_id = 0
    type = 0
    rr = randrange(100)
    if rr < 40:
        type = 1
    elif rr < 60:
        type = 2
    elif rr < 80:
        type = 3
    else:
        type = 4
        
    ind = type - 1
    if gam:
        if ind >= 0 and ind < len(gam.pool_arr): 
            pol = gam.pool_arr[ind]
            pool_acct_id = pol.account_id
            cutoff = game_rand_arr[ind]
            rr = randrange(100)
            if pol.spread_favorite:
                fav = pol.spread_favorite
                udog = gam.getOtherTeam(pol.spread_favorite)
            else:
                fav = gam.rot_id_arr[1]
                udog = gam.rot_id_arr[0]
            if type == 4 and rr < cutoff:
                rot_id = OVER
            elif type == 4:
                rot_id = UNDER
            elif rr < cutoff:
                rot_id = fav
            elif rr < 91:
                rot_id = udog
            elif type == 3:
                rot_id = PUSH
            else:
                rot_id = udog
    return (pool_acct_id, rot_id, type)

def getPoolAccount3(gam):
    pool_acct_id = gam.pool_arr[0]
    rot_id_dic = {}
    # 1 in 20 times: pick 1 push
    # 1 in 200 times: pick 2 pushes
    # 1 in 2000 times pick 3 pushes
    randy = randrange(10000)
    if randy < 5:
        ind1 = randrange(6)
        ind2 = randrange(6)
        ind3 = randrange(6)
        while ind1 == ind2:
            ind2 = randrange(6)
        while ind1 == ind3:
            ind3 = randrange(6)
            while ind2 == ind3:
                ind3 = randrange(6)
        while ind2 == ind3:
            ind3 = randrange(6)
            while ind3 == ind1:
                ind3 = randrange(6)
        if ind1 == ind2 or ind2 == ind3 or ind1 == ind3:
            ind1 = 0
            ind2 = 1
            ind3 = 2
        rot_id_dic[ind1] = PUSH
        rot_id_dic[ind2] = PUSH
        rot_id_dic[ind3] = PUSH
    elif randy < 50:
        ind1 = randrange(6)
        ind2 = randrange(6)
        while ind1 == ind2:
            ind2 = randrange(6)
        rot_id_dic[ind1] = PUSH
        rot_id_dic[ind2] = PUSH
    elif randy < 500:
        ind = randrange(6)
        rot_id_dic[ind] = PUSH

    for i in range(6):
        if not rot_id_dic.get(i):
            if i < len(gam.game_arr):
                rot_id_arr3 = gam.game_arr[i].rot_id_arr
            else:
                rot_id_arr3 = []
            randy2 = randrange(100)
            if randy2 < 50 and rot_id_arr3:
                b_rot = rot_id_arr3[0]
            elif rot_id_arr3:
                b_rot = rot_id_arr3[1]
            else:
                b_rot = 0
            rot_id_dic[i] = b_rot
    return (rot_id_dic[0],rot_id_dic[1],rot_id_dic[2],rot_id_dic[3],rot_id_dic[4],rot_id_dic[5])

def getPick6NumBets():
    retsize = 10    
    randy = randrange(100)
    if randy < 1:
        retsize = 2
    elif randy < 2:
        retsize = 3
    elif randy < 4:
        retsize = 4
    elif randy < 7:
        retsize = 5
    elif randy < 16:
        retsize = 8
    elif randy < 86:
        retsize = 10
    elif randy < 95:
        retsize = 12
    elif randy < 98:
        retsize = 14
    else:
        retsize = 20
    return retsize

def getPick6BetSize(bettup):
    retsize = 1
    randy = randrange(100)
    if PUSH in bettup:
        if randy >= 66:
            retsize = 2
    else:
        if randy < 25:
            retsize = 1
        elif randy < 50:
            retsize = 2
        elif randy < 70:
            retsize = 5
        elif randy < 85:
            retsize = 10
        elif randy < 90:
            retsize = 20
        elif randy < 95:
            retsize = 50
        else:
            retsize = 100
    return retsize
    
def makeFakeBets(customerArr, betSec=4, maxLoops=2):
    delay = 1.0                 # run loop every second
    sum_spread = 0.0
    sum_ml = 0.0
    sum_pwp = 0.0
    sum_overunder = 0.0
    ret_tup = makeGameArrays()
    game_array = ret_tup[0]
    big_game_array = ret_tup[1]
    if game_array or big_game_array:
        for i in range(maxLoops):   # maxLooops, how long to run simulation 10 minutes = 600
            if not i % betSec:
                cus = getCustomer(customerArr)
                if cus:
                    gam = getGame(game_array)
                    if big_game_array:
                        gam2 = big_game_array[0] 
                    else:
                        gam2 = None
                    if gam:
                        rettup = getPoolAccount2(gam)
                        pool_acct_id = rettup[0]
                        rot_id = rettup[1]
                        type = rettup[2]
                        betSize = float(getRandomGBet(avg_betsize, std_betsize))
                        if betSize > cus.balance:
                            if cus.makeDeposit(min_balance):
                                print "%s. Deposit Error on customer %s." % (i, cus.username)
                        if cus.makeBet(pool_acct_id,betSize,rot_id):
                            err = 1
                            print "%s. Bet Error on customer %s." % (i, cus.username)
                        else:
                            err = 0
                        if not err:
                            if type == 1:
                                sum_spread += betSize
                            elif type == 2:
                                sum_ml += betSize
                            elif type == 3:
                                sum_pwp += betSize
                            elif type == 4:
                                sum_overunder += betSize
                    if gam2: 
                        numBets = getPick6NumBets()
                        for j in range(numBets):
                            bet_tup = getPoolAccount3(gam2)
                            pool_acct_id = gam2.pool_arr[0].account_id
                            betSize = getPick6BetSize(bet_tup)
                            if betSize > cus.balance:
                                if cus.makeDeposit(min_balance):
                                    print "%s. Deposit Error2 on customer %s." % (i, cus.username)
                            if cus.makeBet(pool_acct_id,betSize,bet_tup):
                                err = 1
                                print "%s. Bet Error2 on customer %s." % (i, cus.username)
                            else:
                                err = 0                    
            time.sleep(1.0)
        print "finished bet sim. Total bets on Spread pool = %s. Total bets on Moneyline = %s. Total bets on PWP = %s. Total bets on Over Under = %s" % (sum_spread,sum_ml,sum_pwp,sum_overunder)
    else:
        print "finished bet sim. No Games in Game Display Table"

if __name__ == '__main__':
    if len(sys.argv) > 2:
        loops = int(sys.argv[1])
        delay = int(sys.argv[2])
    elif len(sys.argv) > 1:
        loops = int(sys.argv[1])
        delay = 4
    else:
        loops = 600
        delay = 4

    customerArr = populateCustomerDB()
    makeFakeBets(customerArr, delay, loops)
