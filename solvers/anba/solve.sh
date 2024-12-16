#!/bin/bash -x

if [ ! -e ./case.bdf ]; then
  echo "error: run from case directory"
  exit 1
fi
if [ ! -d ./run ]; then
  echo "error: run dir does not exist"
  exit 1
fi
if [ -z "${1}" ]; then
  echo "error: specify the problem type"
  exit 1
fi

problem_type=${1}
problem_hash=($(md5sum case.bdf))

cat << EOF > run/${problem_hash}.json
{
  "status": "running",
  "pid": $$
}
EOF

cd run || exit 3

# lancia ANBA
../../../../../bin/anba ../case.bdf > ${problem_hash}.log 2>&1
anba_error=$?

if [ $anba_error -eq 0 ]; then
  # se ANBA produce risultati in ${problem_hash}.log, puoi elaborarli qui
  # ad esempio estrai stiffness:
  stiffness_value=1234  # esempio
  status="success"
  echo "{\"status\":\"$status\",\"stiffness\":$stiffness_value}" > ${problem_hash}.json
else
  status="error"
  echo "{\"status\":\"$status\",\"error\":\"ANBA failed\"}" > ${problem_hash}.json
fi

rm -f ${dir}/${problem_hash}.pid