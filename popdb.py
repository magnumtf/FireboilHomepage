import time
import MySQLdb as mdb
import sys
import random

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


#note to self:
#  make an odds table that python can update in the background.  This is what the fb website should use to update
#  the forms.


# pre-requisites: you need a player table with 1000 players jesushouse1 .. jesushouse1000

# a game setup:
#	1. create game desc table.
#	2. add entries to entry table
#	3. hawshoo


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


def makeTestBet(pool_id, p_id):
    con = None
    try:
        con = mdb.connect('localhost', 'root', 'rootsuit3278', 'fireboil_db')
        cur = con.cursor()
# 4 pools: spread, moneyline, pwp, and overunder
# generate bets based on ????
# betSize will be uniformly random from 100 - 1000.
    #make bet into spread pool.
    betSize = getRandomGBet(avg_betsize, std_betsize)
    randr = random.randrange(100)
    if randr+1 <= spread_giants:
        giants_bet = betSize
        ne_bet = "0.0"
    else:
        giants_bet = "0.0"
        ne_bet = betSize
    total_bet = betSize
    player_acct_id = getPlayeractt()
    pool_acct_id = getPoolactt()
    cur.execute("INSERT INTO test(tp_spread, nyg_pool, ne_pool) VALUES(%s,%s,%s)", (total_bet, giants_bet, ne_bet))
    cur.execute("INSERT INTO transaction(from_acct_id, to_acct_id, amount, type, status) VALUES(%s,%s,%s)", 
(player_acct_id, pool_acct_id,betSize)
    # now take the money from one account to another
    # log the bet somewhere.
betTable
    bet_id, pool_id (there are some parameters associated here, now haw shoo!)
    # now you must commit!!!!!
    #get test_id
    test_id = con.insert_id()

    #make bet into moneyline pool.
    betSize = getRandomGBet(avg_betsize,std_betsize)
    randr = random.randrange(100)
    if randr+1 <= ml_ne:
        giants_bet = "0.0"
        ne_bet = betSize
    else:
        giants_bet = betSize
        ne_bet = "0.0"
    total_bet = betSize
    cur.execute("UPDATE test SET tp_spread=%s, nyg_pool=%s, ne_pool=%s WHERE test_id=%s", (total_bet, giants_bet, ne_bet, test_id))

    #make bet into pwp pool.
    betSize = getRandomGBet(avg_betsize/3,std_betsize/3)
    randr = random.randrange(100)
    if randr+1 <= pwp_push:
        giants_bet = "0.0"
        ne_bet = "0.0"
        push_bet = betSize
    elif randr+1 <= pwp_push + pwp_giants:
        giants_bet = betSize
        ne_bet = "0.0"
        push_bet = "0.0"
    else:
        giants_bet = "0.0"
        ne_bet = betSize
        push_bet = "0.0"
    total_bet = betSize
    cur.execute("UPDATE test SET tp_spread_pwp=%s, nyg_pool_pwp=%s, ne_pool_pwp=%s, push_pool_pwp=%s WHERE test_id=%s", (total_bet, giants_bet, ne_bet, push_bet, test_id))
    
    #make bet into over under pool.
    betSize = getRandomGBet(avg_betsize,std_betsize)
    randr = random.randrange(100)
    if randr+1 <= over_ou:
        over_bet = betSize
        under_bet = "0.0"
    else:
        over_bet = "0.0"
        under_bet = betSize
    total_bet = betSize
    cur.execute("UPDATE test SET tp_pool_ou=%s, over_pool_ou=%s, under_pool_ou=%s WHERE test_id=%s", (total_bet, over_bet, under_bet))
    #now update the rest of your tables, yep yep.
    #0.

    # 
    # 1. find all status = ACCEPTING or LIMITING tables and update
    odd_id, pool_id, team1_odds, team2_odds ..., total_pool, team1_pool ...
    get odd_id and pool_id
    from pool: use pool_id to find num_entries.  for each entry  for each entry
update_odds - look for big jumps but this is only for display. the actual is done diff.
    you could update the game desc - no the game can have multiple pools.
    a pool has one account and one game_desc, but a game_desc can have multiple pools, now i have to tas.
    so to update a pools odds - collect all transactions to the pool account, calculate the odds and update them in the odds table.
        odds table - odd_id pool_id game_desc_id account_id num_entries total_pool  sum_entry1 sum_entry2 ... odds_entry1 odds_entry2  status IDLE, READY, UPDATING, STOP_UPDATING, FINAL, CLOSED
        transaction   type  DEPOSIT, WITHDRAWAL, b_credit_w, b_credit_cancel, b_debit,
        make a bet - game_id, pool_id, amount, entries that should be it.
        so to figure out odds look for transaction / amounts for b_debits and totals and put it in odds table. 
    meta_game can have one multiple games yep yep yep
    
    

, tp_spread_ml, nyg_pool_ml, ne_pool_ml, tp_spread_pwp, nyg_pool_pwp, ne_pool_pwp, push_pool_pwp, tp_over_under, over_pool, under_pool) VALUES(

    cur.execute("INSERT INTO test(tp_spread, nyg_pool, ne_pool, tp_spread_ml, nyg_pool_ml, ne_pool_ml, tp_spread_pwp, nyg_pool_pwp, ne_pool_pwp, push_pool_pwp, tp_over_under, over_pool, under_pool) VALUES(

'Jack London')")

    data = cur.fetchone()
    print "Database version : %s " % data

also
    rows = cur.fetchall()
    for row in rows:
        print row

and header description

    desc = cur.description
    print "%s %3s" % (desc[0][0], desc[1][0])

except mdb.Error, e:
    print "Error %d: %s" % (e.args[0],e.args[1])
    sys.exit(1)

finally:
    if con:
        con.close()


def populateTestDB(delay, maxLoops=2):
    conn = MySQLdb.connect (host = "localhost", user = "root", passwd = "rootsuit3278", db = "fireboil_db")
    var = 1
    cnt = 0
    while var == 1:
        val1 = float(cnt + 1)
        val2 = 2.0 * cnt
        sqlStr = "INSERT INTO test (odds_1, odds_2) VALUES (%.1f, %.1f)" % (val1, val2)
        err = 0
        try:
            conn.cursor.execute(sqlStr)
        except:
            err = 1
        if not err:
            conn.commit()
        else:
            print "Database Write Error"
            print sqlStr
        conn.cursor.close()
        time.sleep(float(delay))
        cnt += 1
        if cnt >= maxLoops:
            break
        
    conn.cursor.close()
    conn.close() 

if __name__ == '__main__':
    if len(sys.argv) > 2:
        delay = sys.argv[1]
        loops = sys.argv[2]
    elif len(sys.argv) > 1:
        delay = sys.argv[1]
        loops = 2
    else:
        delay = 1
        loops = 2
    populateTestDB(delay, loops)
