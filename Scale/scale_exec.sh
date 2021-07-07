#!/bin/bash

i=0
while [ $i -le 100 ]; 
do
    ./scale_sim.sh &
    ((i=i+1))
done
