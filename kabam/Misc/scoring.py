"""
    Kabam will use this script to score your submissions. The four defined 
    variables, lt_spend, total_logins, power, and num_friends will be scored
    using this script. 

    Please ensure that the groups CSV file is compatible.
"""
import os
import sys

import pandas as pd
from sklearn.metrics import mean_absolute_error as mae


def get_submission():
    """
      From all files in the directory, look for one that ends with _output.csv
    """
    result_files = []
    for filename in os.listdir("."):
        if filename.endswith("_output.csv"):
            result_files.append(filename)
    return result_files[0]


def score_results(compared):
    """
    """
    columns = ['lt_spend', 'total_logins', 'power', 'num_friends']
    maes = []
    for column in columns:
        column_1 = column + "_x"
        column_2 = column + "_y"
        column_mae = mae(merged[[column_1]], merged[[column_2]])
        maes.append(column_mae)
    return maes


if __name__ == "__main__":
    # test_file will be the hold out set internal to Kabam
    test_file = sys.argv[1]
    test = pd.read_csv(test_file)

    # submission will be the contestants submitted output
    try:
        submission = get_submission()
        group_name = submission.split("_output")[0]
        print (f"group name: {group_name}")
        submitted_values = pd.read_csv(submission)
        merged = test.merge(submitted_values, on='uid', how='inner')
        scores = score_results(merged)
        print (f"Scores for {group_name} are {scores}")
    except:
        print (f"no valid submission found.")
