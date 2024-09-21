import { showModel as showUserModel } from '@models/user'

export default {

    namespaced: true,

    state() {
        return {
            user: null,
            stats: {
                coursesInProgress: 0,
                completedCourses: 0,
                dedicationTime: 0,
                teacherRating: 0,
                teacherReviews: 0,
                teacherStudents: 0,
                commentsCount: 0,
            },
            isHeadTeacher: false,
        }
    },

    getters: {
        //
    },

    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setStats(state, user) {
            state.stats.coursesInProgress = user.payload.courses_in_progress;
            state.stats.completedCourses = user.payload.completed_courses;
            state.stats.dedicationTime = user.payload.dedication_time;
            state.stats.commentsCount = user.payload.comments_count;

            state.stats.headTeacherEnrollments = user.payload.teacher_courses;
            state.stats.teacherRating = user.payload.teacher_rating;
            state.stats.teacherReviews = user.payload.teacher_reviews;
            state.stats.teacherStudents = user.payload.teacher_students;
        },
        setIsHeadTeacher(state, isHeadTeacher) {
            state.isHeadTeacher = isHeadTeacher;
        }
    },

    actions: {
        async initModule({ dispatch }, { userId }) {
            await dispatch('fetchUser', userId);
        },
        async fetchUser({ commit }, userId) {
            let user = await showUserModel(userId, [
                'inProgressEnrollments.course',
                'completedEnrollments.course',
                'headTeacherEnrollments.course.product',
            ], [], {
                appends: [
                    'profile_background_url',
                    'courses_in_progress',
                    'completed_courses',
                    'dedication_time',
                    'comments_count',
                ]
            });

            if (user.head_teacher_enrollments.length > 0) {
                commit('setIsHeadTeacher', true);
            }
            commit('setUser', user);
            commit('setStats', user);
        },
    }
}