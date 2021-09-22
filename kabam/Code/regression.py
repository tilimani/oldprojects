import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import dask.dataframe as dd

from dask.distributed import Client, LocalCluster
cluster = LocalCluster(n_workers=0)
client = Client(cluster)

w = cluster.start_worker(ncores=4, memory_limit=8000000000)

users = dd.read_csv('/Users/alex/desktop/kabam/data/ubc_vc_2019_users.csv', low_memory=False)
joined = dd.read_csv('/Users/alex/desktop/kabam/joined/kabam_vc_joined-09.csv', low_memory=False)



print ('hello world')

print(users.head(0))

print("-----------")

