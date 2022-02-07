import React from 'react';
import Skeleton from '@material-ui/lab/Skeleton';
import Grid from '@material-ui/core/Grid';
import Box from '@material-ui/core/Box';

const SiteListSkeleton = () => {
	return (
		<div className="site-list-loading-skeleton">
			<Grid container>
				<Grid item xs={ 12 }>
					<Box display="flex" justifyContent="center">
						<Skeleton
							variant="rect"
							width={ 600 }
							height={ 36 }
							animation="wave"
						/>
					</Box>
				</Grid>
				<Grid item xs={ 12 }>
					<Box
						display="flex"
						justifyContent="center"
						m="44px 0 50px 0"
					>
						<Skeleton
							variant="rect"
							width={ 740 }
							height={ 48 }
							animation="wave"
						/>
					</Box>
				</Grid>
				<Grid item xs={ 12 }>
					<Box
						display="flex"
						justifyContent="space-between"
						p="0 0 8px 0"
					>
						<Box display="flex" gridGap="15px" alignItems="center">
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 80 }
									height={ 41 }
									animation="wave"
								/>
							</Box>
						</Box>
						<Box display="flex" gridGap="15px" alignItems="center">
							<Box>
								<Skeleton
									variant="rect"
									width={ 110 }
									height={ 40 }
									animation="wave"
								/>
							</Box>
							<Box>
								<Skeleton
									variant="rect"
									width={ 110 }
									height={ 40 }
									animation="wave"
								/>
							</Box>
						</Box>
					</Box>
				</Grid>
				<Grid item xs={ 12 }>
					<Box
						p="44px 0 0 0"
						display="grid"
						gridGap="40px"
						gridTemplateColumns="1fr 1fr 1fr 1fr"
					>
						<Skeleton
							variant="rect"
							height={ 380 }
							animation="wave"
						/>
						<Skeleton
							variant="rect"
							height={ 380 }
							animation="wave"
						/>
						<Skeleton
							variant="rect"
							height={ 380 }
							animation="wave"
						/>
						<Skeleton
							variant="rect"
							height={ 380 }
							animation="wave"
						/>
					</Box>
				</Grid>
			</Grid>
		</div>
	);
};

export default SiteListSkeleton;
