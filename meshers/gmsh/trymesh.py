#!/usr/bin/python3
import sys
sys.path.append("../../../../bin")
import gmsh
import math
import os
import json
import signal

def mesh(attempt):
  result = {}
  gmsh.initialize()
  gmsh.option.setNumber("General.Terminal", 1)
  # gmsh.option.setNumber("General.Verbosity", 1) # (0: silent except for fatal errors, 1: +errors, 2: +warnings, 3: +direct, 4: +information, 5: +status, 99: +debug)
  gmsh.option.setNumber("Mesh.Optimize", 0)
  gmsh.merge("cad.xao")

  lc = 0
  if attempt != 0:
    if attempt != 1:
      gmsh.merge("../../../../meshers/gmsh/default%d.geo" % attempt)

    fp = open("cad.json")
    cad = json.load(fp)
    fp.close()
    lc = math.floor(cad["volume"]/cad["area"] * (6-attempt) * 1e2)*1e-2   
    gmsh.option.setNumber("Mesh.MeshSizeMax", lc)
    gmsh.option.setNumber("Mesh.MeshSizeMin", 1e-2*lc)

  try: 
    gmsh.model.mesh.generate(3)
    
  except:
    result["result"] = "failed"
    nodes, _, _ = gmsh.model.mesh.getNodes()
    result["lc"] = lc
    result["nodes"] = len(nodes)
    result["error"] = gmsh.logger.getLastError()
    result["error_entity"] = list(gmsh.model.mesh.getLastEntityError())
    # numpy uses uint64 which json does not like
    result["error_node"] = list()
    for n in gmsh.model.mesh.getLastNodeError():
      result["error_node"].append(int(n))
    return result
        
  result["result"] = "success"
  nodes, _, _ = gmsh.model.mesh.getNodes()
  result["lc"] = lc
  result["nodes"] = len(nodes)
  gmsh.finalize()
  return result

#def handler(signum, frame):
    #signame = signal.Signals(signum).name
    #print(f'Signal handler called with signal {signame} ({signum})')
    #sys.exit(1)

# gmsh installs some signal handlers of its own
# I cannot seem to catch signals
#signal.signal(signal.SIGTERM, handler)
#signal.signal(signal.SIGINT, handler)
#signal.signal(signal.SIGKILL, handler)
#signal.signal(signal.SIGHUP, handler)


def main():
  if len(sys.argv) == 2:
    json_file = "attempt%d.json" % (int(sys.argv[1]))
    if os.path.exists(json_file):
      os.remove(json_file)
    result = mesh(int(sys.argv[1]))
    with open(json_file, "w") as fp:
      json.dump(result, fp, indent=2)
    

if __name__ == "__main__":
  main()



