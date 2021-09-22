#import user and session data
user = pd.read_csv('/Users/alex/desktop/kabam/data/ubc_vc_2019_users.csv', low_memory=False, index_col=0)
session = pd.read_csv('/Users/alex/desktop/kabam/data/ubc_vc_2019_sessions.csv', low_memory=False,index_col=0)

#find unique user and session ids
user_uid = user.uid.unique()
sess_uid = session.uid.unique()

#create crossover of data
crossover = set(user_uid).intersection(set(sess_uid))

#create in_session column and initialize as 0
user['in_session'] = 0

#count of users not in session data
not_in_session = 0

#progress bar
progress = 0

#iterate through users and check if in crossover data
for id in range(0, len(user)):
    if user.loc[id, 'uid'] in crossover:
        user.loc[id, 'in_session'] = 1
        if id % 10000 == 0:
            progress = id/len(user)
            print(str(progress * 100)[:4] + "% complete.")

    else:
        not_in_session += 1
        if id % 10000 == 0:
            progress = id/len(user)
            print(str(progress * 100)[:4] + "% complete.")

#prints progress and final test
print("Does " + str(not_in_session) + " equal to " + str((len(user_uid) - len(crossover))))

#convert to csv
user_csv = user.to_csv('/Users/alex/desktop/user_csv.csv')
