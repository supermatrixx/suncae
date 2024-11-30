# SunCAE tutorials

## Overview

 - [Tutorial #1: Overview](https://youtu.be/MYl7-tcCAfE) (4 min)

Hello and welcome to this first overview & tutorial video for SunCAE.
Let's go straight to the point and create a new case.

For now, let's drag and drop a step file with a simple square beam.
Next we select the physics and the problem.

Here we are, this is the main view. These two panels can be dismissed.
This is important when using SunCAE from a mobile device. But that's a topic for a different video.

Ok, let's solve a CAE problem.
Add a condition, magenta, click on the end face.
By default this will be fixed. That's fine.

Add another one, green, now with a pressure. Solve.

Good. This is a first public release so there are a lot of things to add and improve. 

We can see that the default mesh is a little bit coarse, so we can go back to the meshing step and create a finer mesh.
This histogram tells us the distribution of the element sizes.
Not very nice. The height and width is ten millimeters. The length is one hundred millimeters.
So let's choose a size of two.

Now that's better. Let's go back to the results to see what happens now.

Since we fully fixed the magenta face we get these stress concentrations at the corners.
Let's change that fixation to a symmetry condition, both in the tangential and radial directions.
Right now I have to type it. I'll explain whats going on when I type stuff in another video.
We can solve again.

And now the von Mises stress is identically equal to the pressure.
Let's now investigate bending.
Instead of pressure, we can set a vertical load. We need to write Fz equals minus one hundred.

What if we wanted both ends fixed?
First, fix back the magenta surface. We can do that by fixing the three degrees of freedom.
Then do the same with the green surface.
And add a new load at the top.

What if we do not want to fully fix the ends but use roller supports?
No problem, instead of applying conditions to faces let's pick edges.
We can start all over again. We can pick edges as we picked faces.

But also we can enter the numerical ids. Again, more details in other videos.

This is the same problem that the PrePoMax tutorial series show how to solve in the first place.
I'll add the link to that video in the description. It is nice to compare different open-source approaches.

That was it, let me known in the comments if you have questions or something you'd like me to discuss in other videos.
Thanks for watching.

 
 
## NAFEMS LE10

 - [Tutorial #2: NAFEMS LE10](https://youtu.be/ANQX0EZI_q8) (4 min)

Hello and welcome to this SunCAE tutorial.
Today we're going to solve the NAFEMS LE10 Benchmark.

Here we have the CAD file in STEP format.
The problem asks for linear elasticity, so there we go.

It then says what the boundary conditions are.
Uniform normal pressure of 1 Megapascal on the upper surface of the plate. Done.
This face DCDC has to have zero y displacement, which is fixed $v$.
This one ABAB zero $u$.
This one BCBC zero $u$ and zero $v$.
Finally this edge, zero $w$.

Now, material properties. Isotropic elastic.
Young modulus two hundred ten Giga pascals, uniform.
Poisson's ratio, the good old zero point three.
And we're done. Let's solve this.

Ok, first thing. The mesh looks coarse, doesn't it?
But there's something else we can do before refining.
The problem asks for the normal stress in the y direction evaluated at point D.
We would use "probes" to get this result, but that feature is still not implemented.
Instead, we are going to ask for that value directly to the solver.
Let's go back to the problem step.
Let me explain a little technical detail.
These choices for the boundary conditions and material properties are stored directly in the FeenoX input file.
So if I change something here, it will be reflected in the input file.

And the other way round! If I edit the input file, the UX will reflect that---as long as it understands it.
But also, it means we can add custom instructions here.
Let's ask FeenoX to print out the requested result, namely $\sigma_y$ at the position of point D, which is two meters, zero, three hundred.
If we now solve, we get the same as before but also this console output down here with the result.
Let's refine the mesh to see if we can improve that number.
Remember the reference result is five point thirty eight.
First thing we can do is perform a global mesh refinement. The thickness is six hundred.
Let's choose one hundred fifty.

Better, but we can still improve. Very much like for the solver, the meshing settings are stored in the Gmsh's input file in geo format.
We can edit the mesh size in the file, say two hundred and the UX will reflect that.

And again, we can enter settings which are not yet supported by the UX.
In particular, we want to locally refine around the point where we evaluate $\sigma_y$.
I already have the needed lines in order to refine locally around point D.


We can see that the mesh is indeed refined around the point of interest.
Let's solve again...

The actual result is not important here, because we are far away from the converged mesh.
That was it.
Let me known in the comments if you have questions or something you'd like me to discuss in other videos.
Thanks for watching.

## Heat conduction

 - [Tutorial #3: Heat conduction](https://youtu.be/WeEeZ5BVm8I) (3.5 min)

Hello and welcome to this SunCAE tutorial.
Today we're going to solve a heat conduction problem.

We are going to use a simple square beam.
Now, we have to choose "heat transfer" and then "heat conduction."

Cool. First thing we are going to do is to add a boundary condition and set temperature equal to zero here.
And then add another one, temperature equal one here.
We can check this is the case. Cool. Solve. Ok, we have this nice linear rainbow.

Let's go back and replace the red BC with a prescribed heat flux, let's say ten to minus three.
The profile is the same but now the temperature is higher.

Another problem. This little beam is ten millimeters long in the x direction.
Let me put back a temperature here let's put it back equal to one hundred.
Now let's change the conductivity. It used to be one, let me write one plus x.
So the conductivity increases along the axial coordinate.

Now the rainbow is hotter.
If we go back and write eleven minus x.
It is colder.


Another problem. Let me delete this boundary condition and add this face to the purple one.
So zero and zero.
Now... let's put back conductivity to one and let's add power, say ten to minus two. 
Now the center is hot, up to a hundred twenty four.

What if the conductivity depended on temperature?
Ok, let's say it increases with temperature like linearly, 1+T.
And now we are solving a non-linear problem under the hood.
So that center is still hot, but you know, up fifteen not a hundred twenty four.
This is not physically real, but you get the point, don't you?

Finally, let's go back. Conductivity one again and now the power a sine of x.
We have stripes. But these stripes don't look good, do they?
This is because the mesh is pretty coarse.
So let's go back to the first step and let's change the element size.
Instead of one, let's pick zero point two.
And also let's choose algorithm eight in Gmsh which gives nicer tets.
And now the stripes are nicer. 

That was it.
Let me known in the comments if you have questions or something you'd like me to discuss in other videos.
Thanks for watching.
 
