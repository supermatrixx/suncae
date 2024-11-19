# Roadmap

 * more problems
 * more meshers
 * more solvers
 * more runners (ssh, aws, kubernetes, etc.)
 * 

# TODOs

## General

 * choose points for BCs (and eventually refinements)
 * name in the BC should reflect the content
 * dashboard with cases
 * real-time collaboration
 * detect changes in CAD
 * Git tracking, history
 * show face id when hovering
 * screenshots
 * once a minute refresh the axes, faces, edges, etc. (take a snapshot?)
 * investigate defeature operation in OCC through Gmsh (would we need a separate UX?)
 * show SunCAE version in about (mind the fact that the owner of `.git` might not be the one running, maybe we should create a `txt` when running `deps.sh`?)
 * ability to take notes in markdown
 * help ballons, markdown + pandoc
 

## Gmsh

 * STL input
 * combos for algorithms
 * checkboxes for bool
 * local refinements
 * understand failures -> train AI to come up with a proper `.geo`
 * other meshers! (tetget? netgen?)
 * multi-solid: bonded, glued, contact
 * curved tetrahedra
 * hexahedra
 
## Problem

 * other problems: thermal, modal
 * other solvers: ccx, sparselizard
 * orthotropic elasticity
 * thermal expansion (isotropic and orthotropic)
 * thermal feenox
 * modal feenox
 * mechanical sparselizard
 * transient/quasistatic
 
## Results

 * fields
 * probes
 * reactions
 * console outout (from PRINTs)
 * download VTK
 
## Outer loops

 * parametric
 * optimization
 
## Dashboard

 * list of cases

## Backlog

 * zoom over mouse
 * disable BCs (comment them out)
