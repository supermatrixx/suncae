# Roadmap

 * more problems (non-linear mechanics, transient thermal, modal, cfd, etc.)
 * more meshers (netgen? tetgen? salome?)
 * more solvers (sparselizard? ccx? fenics?)
 * more runners (ssh, aws, kubernetes, etc.)
 * more documentation

# TODOs

## General

 * choose units
 * choose points for BCs (and eventually refinements)
 * name in the BC should reflect the content
 * dashboard with case list
 * real-time collaboration
 * detect changes in CAD
 * git history in the ux
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

 * other problems: modal
 * other solvers: ccx, sparselizard
 * orthotropic elasticity
 * thermal expansion (isotropic and orthotropic)
 * modal feenox
 * mechanical sparselizard
 * transient/quasistatic (a slider for time?)

## Results

 * fields (the list of available fields should be read from the outpt vtk/msh)
   - heat flux? (more general, vector fields?)
 * the server should tell the client
   - which field it is returning (so the client can choose the pallete)
   - if it has a warped field or not
 * the range scale has to be below the warp slider
 * nan color (yellow)
 * compute the .dat in the PHP, not in Bash
 * probes: user picks location, server returns all field
 * reactions: choose which BCs to compute reaction at in the problem step with a checkboxes
 * warning for large deformations/stresses

## Outer loops

 * parametric
 * optimization
 
## Dashboard

 * list of cases

## Backlog

 * zoom over mouse
 * disable BCs (comment them out)
