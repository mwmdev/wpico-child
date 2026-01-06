#!/bin/bash

# Function to kill background processes on script exit
cleanup() {
    echo -e "\nShutting down..."
    kill $(jobs -p) 2>/dev/null
    exit
}

# Set up trap for cleanup on script exit
trap cleanup EXIT INT TERM

# Start WordPress server in background
wp server --port=8000 --config=/home/mike/cloud/dev/cfg/php.ini &

# Wait a bit for the server to start
sleep 3

# Start Gulp tasks
echo "Starting Gulp tasks..."
npm start

# Keep script running
wait 