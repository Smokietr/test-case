#!/bin/bash
MAX_REPLICAS=20
CPU_THRESHOLD=70

while true; do
  CURRENT_REPLICAS=$(docker ps --filter "name=backend" --format "{{.ID}}" | wc -l)
  CPU_USAGE=$(docker stats --no-stream --format "{{.CPUPerc}}" $(docker ps -q --filter "name=backend") | awk '{sum += $1} END {print sum/NR}')

  if (( $(echo "$CPU_USAGE > $CPU_THRESHOLD" | bc -l) )) && (( CURRENT_REPLICAS < MAX_REPLICAS )); then
    NEW_REPLICAS=$((CURRENT_REPLICAS + 1))
    echo "Scaling up backend to $NEW_REPLICAS replicas"
    docker compose up -d --scale backend=$NEW_REPLICAS
  elif (( $(echo "$CPU_USAGE < 40" | bc -l) )) && (( CURRENT_REPLICAS > 1 )); then
    NEW_REPLICAS=$((CURRENT_REPLICAS - 1))
    echo "Scaling down backend to $NEW_REPLICAS replicas"
    docker compose up -d --scale backend=$NEW_REPLICAS
  fi

  sleep 30
done
